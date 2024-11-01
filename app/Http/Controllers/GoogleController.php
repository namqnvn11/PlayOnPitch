<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;


class GoogleController extends Controller
{
    public function redirectToGoogle(){
        return Socialite::driver('google')->redirect();
    }
    public function handleGoogleCallback(){
        $user = Socialite::driver('google')->stateless()->user();

        $findUser= User::where('google_id', $user->id)->first();
        if($findUser){
            Auth::login($findUser);
        }
        else{
            $newUser = User::updateOrCreate([
                'email' => $user->email,
            ],[
                'full_name' => $user->name,
                'google_id'=> $user->id,
                'password' => encrypt('abcd1234')
            ]);
            Auth::login($newUser);
        }
        return redirect()->intended('/dashboard');
    }
}
