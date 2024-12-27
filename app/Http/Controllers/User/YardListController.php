<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Boss;
use App\Models\District;
use App\Models\Province;
use App\Models\Yard;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class YardListController extends Controller
{
    public function index(Request $request)
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
        $yardName = $request->input('yard_name');
        $provinceId = $request->input('province_id');
        $districtId = $request->input('district_id');

        $query = Boss::query();

        if ($provinceId) {
            $districtIds = District::where('province_id', $provinceId)->pluck('id');
            $query->whereIn('district_id', $districtIds);
        }

        if ($districtId) {
            $query->where('district_id', $districtId);
        }

        if ($yardName) {
            $query->where('company_name', 'LIKE', '%' . $yardName . '%');
        }

        $baseUrl = app()->environment('production') ? env('APP_URL') : url('/');
        $currentUser = Auth::guard('web')->check()?'user':'guest';
        // Chỉ lấy những boss có ít nhất 1 sân không bị chặn
        $bosses = $query->whereHas('yards', function ($q) {
            $q->where('block', false);
        })
            ->orderBy('created_at', 'desc')
            ->paginate(8)->withPath($baseUrl . '/'.$currentUser.'/yardlist/index' );

        return view('user.yard_list.index', compact('bosses', 'District', 'Province'));
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
