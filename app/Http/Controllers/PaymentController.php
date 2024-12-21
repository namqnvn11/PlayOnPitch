<?php

namespace App\Http\Controllers;

use App\Models\Boss;
use App\Models\Contact;
use App\Models\Invoice;
use App\Models\PaymentTransaction;
use App\Models\Reservation;
use App\Models\ReservationHistory;
use App\Models\User_voucher;
use App\Models\Voucher;
use App\Models\YardSchedule;
use App\Services\MomoService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Log;
use Stripe\Exception\ApiErrorException;
use Stripe\StripeClient;
class PaymentController extends Controller
{
    protected $momoService;
    protected $redirectName;

    public function __construct(MomoService $momoService)
    {
        $this->momoService = $momoService;
        $this->redirectName = Auth::check()?'user':'guest';
    }

    public function index(request $request)
    {
        //gia hạn cookies 10' theo momo
        $yardScheduleIds= $request->yard_schedule_ids;
        $boss= Boss::find($request->boss_id);
        $contact= Contact::find($request->contact_id);
        $yardSchedules = YardSchedule::whereIn('id', $yardScheduleIds)->get();
        // Group theo yard_id
        $groupedSchedules = $yardSchedules->groupBy('yard_id');

        $reservationJson = Cookie::get('reservation');
        if (!$reservationJson) {
            return back()->with('error','your reservation is expired, please try again');
        }
        $currentUser=$contact->User;

        return view('user.payment.index')
            ->with(
                [
                    'currentUser' => $currentUser??null,
                    'contact' => $contact,
                    'total_price'=>$request->total_price,
                    'yardSchedules'=>$yardSchedules,
                    'groupedSchedules'=>$groupedSchedules,
                    'boss'=>$boss,
                    'reservation_id'=>$request->reservation_id,
                ]);
    }

    //yardScheduleIds
    public function cancelPayment(request $request){
        $ids= $request->ids;
        $reservationJson = Cookie::get('reservation');
        if ($reservationJson) {
            $reservationCookies = json_decode($reservationJson);
            $count=count($ids);
            for ($i=0;$i<$count;$i++) {
                $yardSchedule=YardSchedule::find($ids[$i]);
                $yardSchedule->update([
                    'status'=>'available',
                    'reservation_id'=>0,
                ]);

            }
            Reservation::find($reservationCookies->reservationId)->update([
                'payment_status'=>'cancelled',
                'reservation_status'=>'cancelled',
            ]);
            ReservationHistory::find($reservationCookies->historyId)->update([
                'status'=>'cancelled',
            ]);

            Cookie::queue(Cookie::forget('reservation'));
            Log::info('cancel payment');
            return redirect()->route($this->redirectName.'.choice_yard.index',$reservationCookies->bossId)->with('error','your reservation is cancelled');
        }
        return redirect()->route('home')->with('error','Something went wrong');
    }
    public function createMoMoPayment(Request $request)
    {
        // xử lý trả full||cọc 20%
        $paymentType=request('payment_type');
        $reservation= Reservation::find(request('reservationId'));
        if ($paymentType=='2'){
            $reservation->update([
                'deposit_amount'=>$request->totalPrice*0.2,
            ]);
        }
        $totalPrice= $paymentType=='1'? $request->totalPrice: $request->totalPrice*0.2;

        //xử lý voucher
        $userVoucherId = $request->user_voucher_id;
        if ($userVoucherId!=0){
            $addedVoucher=User_voucher::find($userVoucherId);
            $totalPrice-=$addedVoucher->Voucher->price;
            session()->put('userVoucherId',$userVoucherId);
        }

        //lưu total price để tính điểm
        session(['totalPrice'=>$totalPrice]);

        $orderId = uniqid();
        $orderInfo = "Payment for order {$orderId}";
        $requestId = time() . "";
        // Gọi đến MomoService để tạo yêu cầu thanh toán
        $momoResponse = $this->momoService->createPayment($orderId, $totalPrice, $orderInfo, 'name',$requestId);
        // Kiểm tra phản hồi từ MoMo bằng 'resultCode'
        if ($momoResponse['resultCode'] === 0) {
            // Lưu thông tin thanh toán vào cơ sở dữ liệu
            $invoice= Invoice::create([
                'reservation_id'=>$request->reservationId,
                'invoice_date'=> now(),
                'total_price'=>$totalPrice,
                'payment_method'=>'momo',
                'status'=>'pending',
            ]);
            session()->put('invoiceId',$invoice->id);

            PaymentTransaction::create([
                'transaction_id' => $momoResponse['orderId'],
                'invoice_id' => $invoice->id,
                'product_name' => 'Yard reservation payment',
                'amount' => $totalPrice,
                'status' => 'Pending',
                'payment_method' => 'MoMo',
                'request_id' => 'non',
                'response_data' => 'non',
            ]);

            // Chuyển hướng người dùng đến URL thanh toán
            return redirect($momoResponse['payUrl']);
        }

        // Xử lý khi yêu cầu thanh toán thất bại
        return back()->withErrors('Payment creation failed: ' . $momoResponse['message']);
    }
    public function handleMoMoPaymentCallback(Request $request)
    {

        try {
            $payment = PaymentTransaction::where('transaction_id', $request->orderId)->first();
            if ($payment) { $invoice= $payment->Invoice()->first();}

            $reservation=Reservation::find($invoice->reservation_id);
            $reservationHistory= $reservation->ReservationHistory()->first();
            if ($payment) {
                $status = $request->resultCode == '0' ? 'Success' : 'Failed';
                $payment->status =$status;
                $invoice->status = $status;
                $reservation->payment_status = $status;
                $reservation->reservation_status = $request->resultCode == '0' ? 'booked' : 'failed';
                $reservationHistory->status=$status;
                $reservationHistory->save();
                $reservation->save();
                $payment->save();
                $invoice->save();
            }

            // thanh toán thành công
            if ($request->resultCode == '0'){
                //xóa voucher của người duùng và session voucherid nếu có
                if (session()->has('userVoucherId')) {
                    $userVoucherId= session('userVoucherId');
                    User_voucher::find($userVoucherId)->delete();
                    session()->forget('userVoucherId');
                }
                $this->updateYardScheduleAndDeleteCookies(true);
                return redirect()->route($this->redirectName.'.invoice.index', $invoice->id)->with('success', 'Payment successful');
            }
            //thất bại
            $this->updateYardScheduleAndDeleteCookies(false);
            return redirect()->route($this->redirectName.'.yardlist.index')->with('error', 'Payment ' . $payment->status);
        }catch (\Exception $exception){
            Log::info($exception->getMessage());
            return redirect('/')->with('error', 'something went wrong');
            }

        }


    public function createStripePayment(Request $request){

        // xử lý trả full||cọc 20% 1=>full 2=>deposit
        $paymentType=request('payment_type');
        $reservation= Reservation::find(request('reservationId'));
        if ($paymentType=='2'){
            $reservation->update([
                'deposit_amount'=>$request->totalPrice*0.2,
            ]);
        }
        $totalPrice= $paymentType=='1'? $request->totalPrice: $request->totalPrice*0.2;
        //voucher nếu có
        $userVoucherId = $request->user_voucher_id;
        if ($userVoucherId!=0){
            $addedVoucher=User_voucher::find($userVoucherId);
            $totalPrice-=$addedVoucher->Voucher->price;
            session()->put('userVoucherId',$userVoucherId);
        }

        $stripe = new StripeClient(config('payment.stripe.stripe_secret'));

        try {
            $response = $stripe->checkout->sessions->create([
                'line_items' => [
                    [
                        'price_data' => [
                            'currency' => 'vnd',
                            'product_data' => [
                                'name' => 'Yard reservation payment',
                            ],
                            'unit_amount' => $totalPrice
                        ],
                        'quantity' => 1,
                    ]
                ],
                'mode' => 'payment',
                'success_url' => route($this->redirectName.'.stripe.payment.success') . '?session_id={CHECKOUT_SESSION_ID}',
                'cancel_url' => route($this->redirectName.'.stripe.payment.cancel'),
            ]);
            if (isset($response['id']) && $response['id'] !== '') {
                session()->put('product_name', 'Yard reservation payment');
                session()->put('totalPrice', $totalPrice);
                session()->put('reservationId', request('reservationId'));
                return redirect($response->url);
            }
        } catch (ApiErrorException $exception) {
            return redirect()->route($this->redirectName.'.stripe.payment.cancel')->with('error', $exception->getMessage());
        }

        return redirect()->route($this->redirectName.'stripe.payment.cancel')->with('error', 'Payment failed!');
    }
    public function handleStripePaymentCallback(Request $request){
        $productName = session()->get('product_name');
        $totalPrice = session()->get('totalPrice');
        $reservationId = session()->get('reservationId');
        $stripe = new StripeClient(config('payment.stripe.stripe_secret'));

        try {
            $response = $stripe->checkout->sessions->retrieve($request->session_id);
            $status = $response['payment_status'];
            $invoiceStatus = $status === 'paid' ? 'success' : 'failed';

            //duùng model payment để lưu thanh toán
            $invoice= Invoice::create([
                'reservation_id'=>$reservationId,
                'invoice_date'=> now(),
                'total_price'=>$totalPrice,
                'payment_method'=>'stripe',
                'status'=>$invoiceStatus,
            ]);
            session()->put('invoiceId',$invoice->id);

            PaymentTransaction::create([
                'transaction_id' => $response['id'],
                'user_id' => '1',
                'invoice_id' => $invoice->id,
                'product_name' =>$productName,
                'amount' => '1',
                'status' => $invoiceStatus,
                'payment_method' => 'Stripe',
                'request_id' => 'non',
                'response_data' => 'non',
                ]);

            //cập nhật trạng thái của reservation vs history
            $reservation=Reservation::find($invoice->reservation_id);
            $reservation->payment_status = $invoiceStatus;
            $reservation->reservation_status =  $status === 'paid' ? 'booked' : 'failed';
            $reservationHistory= $reservation->ReservationHistory()->first();
            $reservationHistory->status=$invoiceStatus;


            $reservationHistory->save();
            $reservation->save();

            //xóa uservoucher khi có tồn tại và khi thanh toán thành công
            if (session()->has('userVoucherId')&& $status === 'paid') {
                $userVoucherId= session('userVoucherId');
                User_voucher::find($userVoucherId)->delete();
                session()->forget('userVoucherId');
            }

            //xóa bỏ các session đang lưu
            session()->forget('product_name');

            //update schedule status
            $this->updateYardScheduleAndDeleteCookies(true);

            return redirect()->route($this->redirectName.'.invoice.index',$invoice->id)->with('success', 'Payment successful!');
        } catch (ApiErrorException $e) {
            return redirect()->route($this->redirectName.'.stripe.payment.cancel')->with('error', $e->getMessage());
        }
    }

    public function cancel(Request $request)
    {
        //update schedule status
        $this->updateYardScheduleAndDeleteCookies(false);

        return redirect()->route($this->redirectName.'.yardlist.index')->with('error', 'Payment canceled!');
    }

    private function updateYardScheduleAndDeleteCookies($isPaidSuccess)
    {
        if ($reservationJson = Cookie::get('reservation')) {
            $reservationCookies = json_decode($reservationJson);
            $ids= $reservationCookies->yardScheduleIds;
            foreach ($ids as $id) {
                $yardSchedule = YardSchedule::find($id);
                $yardSchedule->update([
                    'status' => $isPaidSuccess ? 'booked' : 'available',
                    'reservation_id' => $isPaidSuccess ? $yardSchedule->reservation_id : 0,
                ]);
            }
            //update quan hệ contact vs invoice
            $invoiceId= session('invoiceId');
            Contact::find($reservationCookies->contactId)->update([
                'invoice_id'=>$invoiceId
            ]);

            //cộng điểm cho người dùng nếu thanh toán thành công
            if ($isPaidSuccess) {
                if (auth()->check()) {
                    $totalPrice= session('totalPrice');
                    $currentUser = auth()->user();
                    $oldScore= $currentUser->score??0;
                    $currentUser->update([
                        'score'=>$oldScore+$totalPrice/10000,
                    ]);
                }
            }
        }
        session()->forget('totalPrice');
        session()->forget('voucherId');
        Cookie::queue(Cookie::forget('reservation'));
    }

}
