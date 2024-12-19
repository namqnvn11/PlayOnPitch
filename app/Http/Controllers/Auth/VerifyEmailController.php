<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User_voucher;
use App\Services\GiveVoucherService;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;

class VerifyEmailController extends Controller
{
    /**
     * Mark the authenticated user's email address as verified.
     */
    public function __invoke(EmailVerificationRequest $request): RedirectResponse
    {
        if ($request->user()->hasVerifiedEmail()) {
            return redirect()->intended(route('user.home.index', absolute: false).'?verified=1');
        }

        if ($request->user()->markEmailAsVerified()) {
            event(new Verified($request->user()));

            //tặng voucher khi xác thực thành công
            try {
                $giveVoucherService= new GiveVoucherService($request->user()->id);
                $giveVoucherService->giveVoucher();
            }catch (\Exception $exception){
                Log::error($exception);
            }

        }

        return redirect()->intended(route('user.home.index', absolute: false).'?verified=1');
    }
}
