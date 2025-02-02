<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Jobs\SendOtpEmailJob;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'phone' => ['required', 'string', 'regex:/^((\+84|0)(\d{9,10}))|((0\d{2,3})\d{7,8})$/'],
        ]);
        $otp_code= rand(100000,999999);
        $user = User::create([
            'full_name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone' => $request->phone,
            'address' => '',
            'district_id' => 0,
            'block' => 0,
            'otp_code'=> $otp_code,
            'otp_expires_at' => Carbon::now()->addMinutes(5),
        ]);

        event(new Registered($user));

        Auth::login($user);

        // Đưa email vào hàng đợi để gửi
        SendOtpEmailJob::dispatch($user->email, $user->otp_code);

        return redirect()->route('verification.notice');
    }
}
