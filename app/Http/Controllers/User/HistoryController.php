<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\ReservationHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HistoryController extends Controller
{
    public function index(){
        $histories = ReservationHistory::with([
            'Reservation.YardSchedules.Yard.Boss.images'
        ])->where('user_id', Auth::id())->where('status','success')
            ->orderBy('created_at', 'desc')
            ->get();
        return view('user.history.index', compact('histories'));    }
}
