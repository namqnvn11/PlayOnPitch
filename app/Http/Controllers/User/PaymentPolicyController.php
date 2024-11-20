<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PaymentPolicyController extends Controller
{
    public function index(){
        return view('user.payment_policy.index');
    }
}
