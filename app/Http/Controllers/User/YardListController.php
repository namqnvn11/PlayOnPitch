<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\District;
use App\Models\Province;
use App\Models\Yard;
use Illuminate\Http\Request;

class YardListController extends Controller
{
    public function index(Request $request)
    {
        $District = District::all();
        $Province = Province::all();
        $yard_name = $request->input('yard_name');
        $yards = Yard::query();

        if ($request->filled('province_id')) {
            $districtIds = District::where('province_id', $request->province_id)->pluck('id');
            $yards = $yards->whereIn('district_id', $districtIds);

            if ($request->filled('district_id')) {
                $yards = $yards->where('district_id', $request->district_id);
            }
        }

        if (!$request->filled('province_id')) {
            $yards = $yards->where('district_id', '!=', null);
        }

        if ($yard_name) {
            $yards = $yards->where('yard_name', 'LIKE', '%' . $yard_name . '%');
        }

        $yards = $yards->get();

        return view('user.yard_list.index', compact('yards', 'District', 'Province'));
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
