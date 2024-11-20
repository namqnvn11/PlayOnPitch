<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User_voucher;
use App\Models\Voucher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MyVoucherController extends Controller
{
    public function index()
    {

        $user_vouchers = User_voucher::where('user_id', Auth::id())->with('Voucher')->get();
        $Voucher = Voucher::all();
        return view('user.my_voucher.index', compact('user_vouchers', 'Voucher'));
    }
}
