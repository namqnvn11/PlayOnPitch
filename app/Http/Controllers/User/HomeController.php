<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\District;
use App\Models\Province;
use App\Models\Yard;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $District = District::all()->sortBy('name');
        $prioritizedProvinces = [' Hà Nội', ' Hồ Chí Minh', ' Đà Nẵng', ' Hải Phòng', ' Cần Thơ'];
        $prioritized = Province::whereIn('name', $prioritizedProvinces)
            ->orderByRaw("FIELD(name, '" . implode("','", $prioritizedProvinces) . "')")
            ->get();

        $otherProvinces = Province::whereNotIn('name', $prioritizedProvinces)
            ->orderBy('name', 'asc')
            ->get();
        $Province = $prioritized->merge($otherProvinces);
        return view('user.home.index', compact( 'District', 'Province'));
    }

    public function getDistricts(Request $request)
    {
        if (!$request->has('province_id')) {
            return response()->json(['error' => 'Province ID is required'], 400);
        }

        $districts = District::where('province_id', $request->province_id)->get();

        if ($districts->isEmpty()) {
            return response()->json(['error' => 'No districts found for this province'], 404);
        }

        return response()->json($districts);
    }
}
