<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\District;
use App\Models\Province;
use Illuminate\Http\Request;

class YardDetailController extends Controller
{
    public function index()
    {
        $District = District::all();
        $Province = Province::all();
        return view('user.yard_detail.index', compact( 'District', 'Province'));
    }
}
