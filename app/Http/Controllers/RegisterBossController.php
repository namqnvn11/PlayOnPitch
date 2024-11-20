<?php

namespace App\Http\Controllers;

use App\Models\RegisterBoss;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RegisterBossController extends Controller
{
    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'unique:register_bosses|email',
            'phone' => ['required', 'string', 'regex:/^((\+84|0)(\d{9,10}))|((0\d{2,3})\d{7,8})$/'],
        ]);

        if ($validator->fails()) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'errors' => $validator->errors()
                ], 422);
            }

            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            $registerBoss = new RegisterBoss();
            $registerBoss->name = $request->input('name');
            $registerBoss->email = $request->input('email');
            $registerBoss->phone = $request->input('phone');
            $registerBoss->save();
            $message = "Registration successful. Please wait, we will contact you.";
            flash()->success($message);

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => $message,
                    'register_boss' => $registerBoss
                ], 200);
            }

            return redirect()->back()->with('message', $message);
        }catch (\Exception $e){
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Registration on the website failed: ' . $e->getMessage()
                ], 500);
            }
            flash()->error($e->getMessage());

            return redirect()->back()->with('error', 'Registration on the website failed: ' . $e->getMessage());
        }
    }
}
