<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Jobs\ExpireReservationJob;
use App\Models\Reservation;
use App\Models\YardSchedule;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\ReservationHistory;
use Illuminate\Support\Facades\Cookie;

class ReservationController extends Controller
{
   function makeReservation(Request $request){

       $yardSchedule=YardSchedule::find(request('scheduleId'));
       $userName= $request->userName;
       $phone= $request->phone;
       $total_price= $request->total_price;

       // Tạo reservation mới
       $reservation = Reservation::create([
           'user_id' => Auth::id(),
           'yard_id' => $yardSchedule->yard_id,
           'reservation_date' => $yardSchedule->date,
           'reservation_time_slot' => $yardSchedule->time_slot,
           'total_price' => $total_price,
           'deposit_amount' => 0,
           'payment_status' => 'pending',
           'reservation_status' => 'paying',
           'code' => uniqid(),
       ]);

       // Tạo lịch sử reservation mới
       $history = ReservationHistory::create([
           'user_id' => $reservation->user_id,
           'reservation_id' => $reservation->id,
           'status' => 'paying',
       ]);

       $expiryTime = now()->addMinutes(15);

       $yardSchedule->update([
           'status' => 'pending',
           'reservation_id' => $reservation->id,
       ]);
       // Lưu id reservation và history lên cookie
       $reservationData = json_encode([
           'userId' => $reservation->user_id,
           'reservationId' => $reservation->id,
           'historyId' => $history->id,
           'yardScheduleId' => $yardSchedule->id,
       ]);
       Cookie::queue('reservation', $reservationData, 15);

       ExpireReservationJob::dispatch($yardSchedule->id)->delay(now()->addMinutes(15));

       return redirect()->route('user.payment.index',[
           'yard_schedule_id'=>$yardSchedule->id,
           'reservation_id'=>$reservation->id,
           'total_price'=>$total_price,
           'phone'=>$phone,
           'user_name'=>$userName,
       ]);
   }
}
