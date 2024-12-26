<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RegisterBoss;
use Illuminate\Http\Request;

class RegisterBossController extends Controller
{
    public function index()
    {
        $baseUrl = app()->environment('production') ? env('APP_URL') : url('/');
        $registerBosses = RegisterBoss::orderBy('created_at', 'desc')->paginate(10)->withPath($baseUrl.'/admin/registerBoss/index');
        return view('admin.registerBoss.index', compact('registerBosses'));
    }

    public function detail(Request $request, $id)
    {
        $response = RegisterBoss::findOrFail($id);

        if($response){
            return response()->json([
                'success'   => true,
                'data'      => $response,
            ]);
        }

        return response()->json([
            'success'   => false,
            'message'   => "Saving failed.",
        ]);

    }
}
