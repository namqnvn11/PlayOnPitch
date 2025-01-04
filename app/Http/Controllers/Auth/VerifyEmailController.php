<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Province;
use App\Services\GiveVoucherService;
use Illuminate\Auth\Events\Verified;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

class VerifyEmailController extends Controller
{
    /**
     * Mark the authenticated user's email address as verified.
     */
    public function __invoke(Request $request): RedirectResponse
    {
        $user = Auth::user();
        // Kiểm tra nếu email đã được xác minh
        if ($user->hasVerifiedEmail()) {
            return redirect()->intended(route('user.home.index', absolute: false).'?verified=1');
        }

        // Lấy mã OTP và kiểm tra tính hợp lệ
        $request->validate([
            'otp_code' => 'required|numeric',
        ]);

        if ($user->otp_code !== $request->input('otp_code')) {
            return redirect()->back()->withErrors(['otp_code' => 'Invalid OTP.']);
        }

        // Kiểm tra nếu OTP đã hết hạn
        if (!$user->otp_expires_at || Carbon::now()->greaterThan($user->otp_expires_at)) {
            return redirect()->back()->withErrors(['otp_code' => 'Your OTP has expired. Please try again.']);
        }

        // Đánh dấu email đã được xác minh
        if ($user->markEmailAsVerified()) {
            event(new Verified($user));

            // Tặng voucher khi xác thực thành công
            try {
                $giveVoucherService = new GiveVoucherService($user->id);
                $giveVoucherService->giveVoucher();
            } catch (\Exception $exception) {
                Log::error($exception);
            }

            // Xóa mã OTP và thời gian hết hạn
            $user->update([
                'otp_code' => null,
                'otp_expires_at' => null,
            ]);
        }
        flash()->success('Your email has been verified.');
        $provinces = Province::all();
        $currentProvince= $user->District->Province??null;
        $districts = $currentProvince->Districts??null;
        $user = Auth::user();
        return redirect()->route('user.profile.index', compact('user','provinces', 'districts'));
    }
}
