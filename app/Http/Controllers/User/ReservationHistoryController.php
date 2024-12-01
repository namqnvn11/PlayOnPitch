<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use App\Models\ReservationHistory;
use App\Models\Yard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReservationHistoryController extends Controller
{
    public function index() {
        $userId = auth()->id();

        $histories = ReservationHistory::with(['reservation', 'reservation.yard'])
            ->where('user_id', $userId)
            ->get();

        return view('user.history.index', compact('histories'));
    }

}
