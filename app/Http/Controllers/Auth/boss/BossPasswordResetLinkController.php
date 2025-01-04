<?php

namespace App\Http\Controllers\Auth\boss;

use App\Http\Controllers\Controller;
use App\Jobs\SendPasswordResetEmail;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BossPasswordResetLinkController extends Controller
{
    /**
     * Hiển thị form nhập email để reset mật khẩu.
     */
    public function create(): View
    {
        return view('auth.boss.forgot-password');
    }

    /**
     * Xử lý gửi email reset mật khẩu.
     */
    public function store(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
        ]);

        // Gửi liên kết reset mật khẩu
        SendPasswordResetEmail::dispatch($request->input('email'),'bosses');

        // Kiểm tra trạng thái và trả về thông báo
        return back()->with('status', __('We have emailed your password reset link!'));

    }
}
