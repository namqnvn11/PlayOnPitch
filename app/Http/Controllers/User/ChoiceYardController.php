<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Boss;
use App\Models\Reservation;
use App\Models\Yard;
use App\Models\YardSchedule;
use Carbon\Carbon;
use Dflydev\DotAccessData\Data;
use Illuminate\Http\Request;

class ChoiceYardController extends Controller
{
    //boss_id
    public function index($id,Request $request){

        $today = now();
        $selectTime= Carbon::parse($request->selectTime)??Carbon::now();
        $dates = collect();
        for ($i = 0; $i < 7; $i++) {
            $dates->push($today->copy()->addDays($i)->toDateString());
        }
        $boss= Boss::find($id);
        $yards = $boss
            ->Yards()
            ->where('block', false)
            ->where('defaultPrice', '>', 0)
            ->with(['YardSchedules' => function ($query) use ($selectTime) {
                $query->where('date', Carbon::create($selectTime->toDateString()));
            }])
            ->get();
        $timeSlots = YardSchedule::where('yard_id',$yards[0]->id)
            ->select('time_slot')
            ->distinct()
            ->get();
        return view('user.choice_yard.index',compact('yards','dates','timeSlots','boss','selectTime'));
    }

    public function showSchedule()
    {
        // Lấy danh sách các sân
        $yards = Yard::all();

        // Lấy danh sách khung giờ (không trùng lặp)
        $timeSlots = YardSchedule::select('time_slot')
            ->distinct()
            ->orderBy('time_slot')
            ->get();

        // Lấy danh sách đặt sân
        $bookings = Reservation::with(['Yard'])
            ->get();

        $currentTime = Carbon::now(); // Lấy giờ hiện tại

        foreach ($timeSlots as $slot) {
            $slot->is_disabled = Carbon::parse($slot->time_slot)->lt($currentTime);
        }

        // Truyền dữ liệu vào view
        return view('user.schedule', [
            'yards' => $yards,
            'timeSlots' => $timeSlots,
            'reservations' => $bookings,
        ]);
    }
}
