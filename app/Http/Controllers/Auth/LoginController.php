<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Boss;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('admin-boss-login');
    }

    public function showLoginUser()
    {
        return view('user.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        $boss = Boss::where('email', $request->email)->first();
        if ($boss && $boss->block == 1) {
            return back()->withErrors(['email' => 'Your account has been blocked.']);
        }

        if (Auth::guard('admin')->attempt($credentials)) {
            return redirect()->route('admin.user.index');
        }
        if (Auth::guard('boss')->attempt($credentials)) {
            return redirect()->route('boss.yard.index');
        }
//        if (Auth::guard('web')->attempt($credentials)) {
//            return redirect()->route('user.home.index');
//        }
        return back()->withErrors(['email' => 'Invalid credentials']);
    }

    public function logout()
    {

        if (Auth::guard('admin')->check()) {
            Auth::guard('admin')->logout();
            return redirect()->route('admin.boss/login');
        }
        if (Auth::guard('boss')->check()) {
            Auth::guard('boss')->logout();
            return redirect()->route('admin.boss/login');
        }
        if (Auth::guard('web')->check()) {
            Auth::guard('web')->logout();
            return redirect()->route('user.home.index');
        }
        return back()->withErrors(['email' => 'Logout Failed']);
    }
}
