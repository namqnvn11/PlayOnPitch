<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Jobs\ExpireReservationJob;
use App\Models\Contact;
use App\Models\Reservation;
use App\Models\YardSchedule;
use Illuminate\Http\Request;
use App\Models\ReservationHistory;
use Illuminate\Support\Facades\Cookie;

class ReservationController extends Controller
{
   function makeReservation(Request $request){

       //nhận được schedule list
       $yardScheduleIds=$request->scheduleIds;

       //kiểm tra schedule list có available
       foreach ($yardScheduleIds as $yardScheduleId) {
           $schedule=YardSchedule::find($yardScheduleId);
           if ($schedule->status!=='available') {
               return back()->with('error','something went wrong, please try again');
           }
       }
       $userName= $request->userName;
       $userId=$request->user_id;
       $bossId=$request->boss_id;
       $phone= $request->phone;
       $total_price= $request->total_price;

       $contact = Contact::firstOrCreate(
           ['phone' => $phone],
           [
               'name' => $userName,
               'phone' => $phone,
               'user_id' => $userId??null,
           ]
       );
       $contact->update(['name' => $userName]);

       $reservation = Reservation::create([
           'user_id' => $userId??null,
           'contact_id' => $contact->id,
           'reservation_date' => now(),
           'total_price' => $total_price,
           'deposit_amount' => 0,
           'payment_status' => 'pending',
           'reservation_status' => 'paying',
           'code' => uniqid(),
       ]);
       $history = ReservationHistory::create([
           'user_id' => $userId??null,
           'reservation_id' => $reservation->id,
           'status' => 'paying',
       ]);
       // Lưu id reservation và history lên cookie
       $reservationData = json_encode([
           'contactId' => $contact->id,
           'bossId' => $bossId,
           'reservationId' => $reservation->id,
           'historyId' => $history->id,
           'yardScheduleIds' => $yardScheduleIds,
       ]);
       Cookie::queue('reservation', $reservationData, 15);

       foreach($yardScheduleIds as $id){
           $yardSchedule= YardSchedule::find($id);
           $yardSchedule->update([
               'status' => 'pending',
               'reservation_id' => $reservation->id,
           ]);
           ExpireReservationJob::dispatch($id)->delay(now()->addMinutes(15));
       }

       return redirect()->route('user.payment.index',[
           'yard_schedule_ids'=>$yardScheduleIds,
           'reservation_id'=>$reservation->id,
           'total_price'=>$total_price,
           'contact_id'=>$contact->id,
           'boss_id'=>$bossId,
       ]);
   }
}
