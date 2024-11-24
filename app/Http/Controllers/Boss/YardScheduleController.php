<?php

namespace App\Http\Controllers\Boss;

use App\Http\Controllers\Controller;
use App\Models\Boss;
use App\Models\YardSchedule;
use App\Models\Yard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class YardScheduleController extends Controller
{
    public function index()
    {
        $yardSchedules = YardSchedule::where('block', 0)->paginate(300);
        $Dates = $yardSchedules->unique('date')->sortBy('date')->values();
        $TimeSlots = $yardSchedules->unique('time_slot');
        return view('boss.yard_schedule.index', compact('yardSchedules', 'Dates', 'TimeSlots'));
    }


}
