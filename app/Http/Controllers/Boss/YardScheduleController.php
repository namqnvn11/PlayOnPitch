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
        $bossId = auth()->user()->id;

        $yards = Yard::where('boss_id', $bossId)->get();

        $yardId = $request->input('yard_id');

        if (!$yardId && $yards->isNotEmpty()) {
            $yardId = $yards->first()->id;
        }

        $query = YardSchedule::where('block', 0);

        if ($yardId) {
            $query->where('yard_id', $yardId);
        }

        $currentDate = now()->startOfDay();
        $endDate = $currentDate->copy()->addDays(6)->endOfDay();
        $query->whereBetween('date', [$currentDate, $endDate]);

        $yardSchedules = $query->paginate(200);

        $Dates = $yardSchedules->getCollection()->unique('date')->sortBy('date')->values();
        $TimeSlots = $yardSchedules->getCollection()->unique('time_slot');

        return view('boss.yard_schedule.index', compact('yardSchedules', 'Dates', 'TimeSlots', 'yards', 'yardId'));
    }

    public function detail(Request $request, $id)
    {
        $reservation = Reservation::with([
            'yardSchedule.yard.boss',
            'yardSchedule.yard.district.province',
            'user'
        ])->findOrFail($id);

        if ($reservation) {
            return response()->json([
                'success' => true,
                'data' => [
                    'reservation' => $reservation,
                    'yard' => $yardSchedule->yard ?? null,
                    'district' => $yardSchedule->yard->district ?? null,
                    'province' => $yardSchedule->yard->district->province ?? null,
                    'user' => $reservation->user ?? null,
                    'yard_schedule' => $yardSchedule ?? null,
                    'boss' => $yardSchedule->yard->boss ?? null,
                ],
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => "Reservation not found.",
        ]);
    }



}
