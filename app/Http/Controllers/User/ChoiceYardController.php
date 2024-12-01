<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Boss;
use App\Models\Reservation;
use App\Models\Yard;
use App\Models\YardSchedule;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ChoiceYardController extends Controller
{
    public function index($id)
    {
        $today = now();
        $dates = collect();
        for ($i = 0; $i < 7; $i++) {
            $dates->push($today->copy()->addDays($i)->toDateString());
        }

        $timeSlots = YardSchedule::select('time_slot')
            ->distinct()
            ->get();

        $yards = Boss::find($id)->yards->filter(function ($yard) {
            return $yard->yardSchedules->isNotEmpty();
        });

        // Lấy danh sách các đặt sân
        $reservations = Reservation::with('yard')
            ->whereIn('reservation_date', $dates) // Giới hạn trong 7 ngày tới
            ->get();

        return view('user.choice_yard.index')->with([
            'yards' => $yards,
            'dates' => $dates,
            'timeSlots' => $timeSlots,
            'reservations' => $reservations,
        ]);
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
