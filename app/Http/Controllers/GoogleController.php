<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\GiveVoucherService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Laravel\Socialite\Facades\Socialite;


class GoogleController extends Controller
{
    public function redirectToGoogle(){
        return Socialite::driver('google')
            ->with(['prompt'=>'select_account'])
            ->redirect();
    }
    public function handleGoogleCallback(){
        $user = Socialite::driver('google')->stateless()->user();

        $findUser= User::where('google_id', $user->id)->first();
        if($findUser){
            // Kiểm tra xem người dùng đã bị block chưa
            if ($findUser->block == 1) {
                return redirect()->route('login')->with('error', 'Your account has been blocked.');
            }
            Auth::login($findUser);
        }
        else{
            $newUser = User::updateOrCreate([
                'email' => $user->email,
            ],[
                'full_name' => $user->name,
                'google_id'=> $user->id,
                'phone' => '',
                'address' => '',
                'district_id' => 1,
                'block' => 0,
                'password' => bcrypt('abcd1234'),
            ]);

            // Tặng voucher sau khi tạo người dùng mới
            try {
                if ($newUser->email_verified_at==null) {
                    $giveVoucherService = new GiveVoucherService($newUser->id);
                    $giveVoucherService->giveVoucher();
                }
            } catch (\Exception $exception) {
                Log::error('Error giving voucher during Google registration: ' . $exception->getMessage(), [
                    'user_id' => $newUser->id,
                    'exception' => $exception,
                ]);
            }
            $newUser->email_verified_at=now();
            $newUser->save();

            // Kiểm tra nếu người dùng bị block
            if ($newUser->block == 1) {
                return redirect()->route('login')->with('error', 'Your account has been blocked.');
            }
            
            Auth::login($newUser);
        }
        return redirect()->intended('/user/home/index')->with('success', 'You are now logged in with Google!');
    }
}
