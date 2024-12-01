<?php

namespace App\Http\Controllers\Boss;

use App\Http\Controllers\Controller;
use App\Models\Boss;
use App\Models\District;
use App\Models\Reservation;
use App\Models\User;
use App\Models\YardSchedule;
use App\Models\Yard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class YardScheduleController extends Controller
{
    public function index(Request $request)
    {
        $yardId = $request->input('yard_id');
        $yards = Yard::all();

        if (!$yardId && $yards->isNotEmpty()) {
            $yardId = $yards->first()->id;
        }

        $query = YardSchedule::where('block', 0);

        if ($yardId) {
            $query->where('yard_id', $yardId);
        }

        $currentDate = now()->startOfDay();
        $endDate = $currentDate->copy()->addDays(7);

        $query->whereBetween('date', [$currentDate, $endDate]);

        $yardSchedules = $query->paginate(300);
        $Dates = $yardSchedules->getCollection()->unique('date')->sortBy('date')->values();
        $TimeSlots = $yardSchedules->getCollection()->unique('time_slot');



        return view('boss.yard_schedule.index', compact('yardSchedules', 'Dates', 'TimeSlots', 'yards', 'yardId'));
    }

    public function detail(Request $request, $id)
    {
        // Tìm thông tin reservation theo ID
        $reservation = Reservation::with(['yard.boss', 'yard.district.province', 'user'])->findOrFail($id);

        if ($reservation) {
            return response()->json([
                'success' => true,
                'data' => [
                    'reservation' => $reservation,
                    'yard' => $reservation->yard,
                    'district' => $reservation->yard->district,
                    'province' => $reservation->yard->district->province,
                    'user' => $reservation->user,
                    'boss' => $reservation->yard->boss,
                ],
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => "Reservation not found.",
        ]);

    }



}
