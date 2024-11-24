<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Boss;
use App\Models\Yard;
use App\Models\YardSchedule;
use Illuminate\Http\Request;

class ChoiceYardController extends Controller
{
    public function index($id){
        $dates = YardSchedule::select('date')
            ->distinct() // Lấy các ngày không trùng lặp
            ->orderBy('date', 'ASC')
            ->take(7)
            ->get();

        $timeSlots = YardSchedule::select('time_slot')->distinct()->get();

        return view('user.choice_yard.index')->with(['yards'=>Boss::find($id)->yards])->with(['dates'=>$dates])->with(['timeSlots'=>$timeSlots]);
    }

    public function showSchedule()
    {
        // Lấy danh sách các sân
        $yards = \DB::table('yards')->get();

        // Lấy danh sách các khung giờ
        $timeSlots = \DB::table('time_slots')
            ->orderBy('time_slot')
            ->get();

        // Lấy danh sách đặt sân từ bảng `bookings`
        $bookings = \DB::table('bookings')
            ->join('yards', 'bookings.yard_id', '=', 'yards.id')
            ->join('time_slots', 'bookings.time_slot_id', '=', 'time_slots.id')
            ->select('yards.yard_name', 'time_slots.time_slot', 'bookings.booking_date')
            ->get();

        // Truyền dữ liệu vào view
        return view('schedule', [
            'yards' => $yards,
            'timeSlots' => $timeSlots,
            'bookings' => $bookings,
        ]);
    }
}
