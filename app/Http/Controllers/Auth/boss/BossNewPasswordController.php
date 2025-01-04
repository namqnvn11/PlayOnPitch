<?php

namespace App\Http\Controllers\Auth\boss;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class BossNewPasswordController extends Controller
{
    /**
     * Hiển thị form đặt lại mật khẩu.
     */
    public function create(Request $request): View
    {
        return view('auth.boss.reset-password', ['request' => $request]);
    }

    /**
     * Xử lý đặt lại mật khẩu mới.
     */
    public function store(Request $request)
    {
        $request->validate([
            'token' => ['required'],
            'email' => ['required', 'email'],
            'password' => ['required', 'confirmed', 'min:8'],
        ]);

        // Kiểm tra URL để xác định loại đối tượng
        $broker = $request->is('boss/*') ? 'bosses' : 'users';

        // Thực hiện reset password với broker phù hợp
        $status = Password::broker($broker)->reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password),
                ])->save();
            }
        );

        // Kiểm tra trạng thái và chuyển hướng
        return $status == Password::PASSWORD_RESET
            ? redirect()->route('admin.boss/login')->with('status', __($status))
            : back()->withInput($request->only('email'))
                ->withErrors(['email' => [__($status)]]);
    }
}
