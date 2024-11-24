<?php

namespace App\Http\Controllers;

use App\Models\PaymentTransaction;
use App\Models\Voucher;
use App\Services\MomoService;
use Illuminate\Http\Request;
use Stripe\Exception\ApiErrorException;
use Stripe\StripeClient;

class PaymentController extends Controller
{
    protected $momoService;

    public function __construct(MomoService $momoService)
    {
        $this->momoService = $momoService;
    }

    public function index()
    {
        $currentUser = auth()->user();
        $vouchers=[];
        foreach ($currentUser->User_Voucher as $uv) {
            $vouchers[]=Voucher::find($uv->voucher_id);
        }
        return view('user.payment.index')->with(['currentUser' => $currentUser, 'vouchers' => $vouchers]);
    }
    public function createMoMoPayment(Request $request)
    {
        $orderId = uniqid();
        $amount = $request->input('totalPrice');
        $orderInfo = "Payment for order {$orderId}";
        $requestId = time() . "";
        // Gọi đến MomoService để tạo yêu cầu thanh toán
        $momoResponse = $this->momoService->createPayment($orderId, $amount, $orderInfo, 'sss',$requestId);
        // Kiểm tra phản hồi từ MoMo bằng 'resultCode'
        if ($momoResponse['resultCode'] === 0) {
            // Lưu thông tin thanh toán vào cơ sở dữ liệu
            PaymentTransaction::create([
                'transaction_id' => $momoResponse['orderId'],
                'user_id' => $request['userId'],
                'invoice_id' => '1',
                'product_name' => $request->input('product_name'),
                'amount' => $amount,
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
        $payment = PaymentTransaction::where('transaction_id', $request->orderId)->first();
        if ($payment) {
            $payment->status = $request->resultCode == '0' ? 'Success' : 'Failed';
            $payment->save();
        }
        return redirect()->route('user.payment.index')->with($request->resultCode == '0' ? 'Success' : 'error', 'Payment ' . $payment->status);
    }

    public function createStripePayment(Request $request){
        $stripe = new StripeClient(config('payment.stripe.stripe_secret'));

        try {
            $response = $stripe->checkout->sessions->create([
                'line_items' => [
                    [
                        'price_data' => [
                            'currency' => 'vnd',
                            'product_data' => [
                                'name' => 'tesst product',
                            ],
                            'unit_amount' => $request->totalPrice
                        ],
                        'quantity' => 1,
                    ]
                ],
                'mode' => 'payment',
                'success_url' => route('user.stripe.payment.success') . '?session_id={CHECKOUT_SESSION_ID}',
                'cancel_url' => route('user.stripe.payment.cancel'),
            ]);
            if (isset($response['id']) && $response['id'] !== '') {
                session()->put('product_name', request('product_name'));
                session()->put('totalPrice', request('totalPrice'));

                return redirect($response->url);
            }
        } catch (ApiErrorException $exception) {
            return redirect()->route('user.stripe.payment.cancel')->with('error', $exception->getMessage());
        }

        return redirect()->route('user.stripe.payment.cancel')->with('error', 'Payment failed!');
    }
    public function handleStripePaymentCallback(Request $request){

        $amount = $request->input('totalPrice');

        $stripe = new StripeClient(config('payment.stripe.stripe_secret'));

        try {
            $response = $stripe->checkout->sessions->retrieve($request->session_id);
            //duùng model payment để lưu thanh toán
            PaymentTransaction::create([
                'transaction_id' => $response['id'],
                'user_id' => '1',
                'invoice_id' => '1',
                'product_name' => $request->input('product_name'),
                'amount' => '1',
                'status' => 'Pending',
                'payment_method' => 'Stripe',
                'request_id' => 'non',
                'response_data' => 'non',
                ]);

            //xóa bỏ các session đang lưu
            session()->forget('product_name');
            session()->forget('totalPrice');

            return redirect()->route('user.payment.index')->with('success', 'Payment successful!');
        } catch (ApiErrorException $e) {
            return redirect()->route('user.stripe.payment.cancel')->with('error', $e->getMessage());
        }
    }


    public function cancel(Request $request)
    {
        return redirect()->route('user.payment.index',)->with('error', 'Payment canceled!');
    }

}
