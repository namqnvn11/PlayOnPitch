<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\ReservationHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HistoryController extends Controller
{
    public function index(){
        $histories = ReservationHistory::with(['reservation.yard.boss']) // Eager load các quan hệ
        ->where('user_id', Auth::id()) // Lọc theo ID người dùng
        ->orderBy('created_at', 'desc') // Sắp xếp theo ngày đặt mới nhất
        ->get();

        return view('user.history.index', compact('histories'));    }
}
