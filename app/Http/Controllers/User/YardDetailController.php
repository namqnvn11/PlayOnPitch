<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\District;
use App\Models\Province;
use App\Models\Yard;
use Illuminate\Http\Request;

class YardDetailController extends Controller
{
    public function index($id)
    {
        $District = District::all();
        $Province = Province::all();
        $yard = Yard::find($id);
        return view('user.yard_detail.index', compact( 'District', 'Province', 'yard'));
    }
}
