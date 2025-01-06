<?php

namespace App\Http\Controllers\Boss;

use App\Http\Controllers\Controller;
use App\Models\Boss;
use App\Models\District;
use App\Models\Province;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use function Laravel\Prompts\error;

class InformationController extends Controller
{
    public function index(){
        $boss = Auth::user();
        $districts = District::all();
        $prioritizedProvinces = [' Hà Nội', ' Hồ Chí Minh', ' Đà Nẵng', ' Hải Phòng', ' Cần Thơ'];
        $prioritized = Province::whereIn('name', $prioritizedProvinces)
            ->orderByRaw("FIELD(name, '" . implode("','", $prioritizedProvinces) . "')")
            ->get();

        $otherProvinces = Province::whereNotIn('name', $prioritizedProvinces)
            ->orderBy('name', 'asc')
            ->get();
        $provinces = $prioritized->merge($otherProvinces);
        return view('boss.information.index',compact('boss','districts','provinces'));
    }

    public function informationUpdate(Request $request){
        $validator = Validator::make($request->all(), [
            'full_name' => 'required',
            'phone' => ['required', 'string', 'regex:/^((\+84|0)(\d{9,10}))|((0\d{2,3})\d{7,8})$/'],
            'company_name' => 'required',
            'company_address' => 'required',
            'district' => 'required',
            'province' => 'required',
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
            Boss::find(request('boss_id'))->update([
                'full_name' => request('full_name'),
                'phone' => request('phone'),
                'company_name' => request('company_name'),
                'company_address' => request('company_address'),
                'district_id' => request('district'),
            ]);
            return response()->json(['success' => true, 'message' => 'Information updated successfully.']);
        }catch (\Exception $exception){
            return response()->json([
                'success' => false,
                'errors' => $exception->getMessage()
            ]);
        }
    }

    public function passwordUpdate(Request $request){
        $validator = Validator::make($request->all(), [
            'old_password' => 'required',
            'new_password' => 'required|min:6|confirmed',
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
            $boss = Boss::find(request('boss_id'));
            if (!Hash::check($request->old_password, $boss->password)) {
                return response()->json([
                    'success' => false,
                    'errors' => [['old password is incorrect']]
                ], 422);
            }
            $boss->password=Hash::make(request('new_password'));
            $boss->save();
            return response()->json(['success' => true, 'message' => 'Password updated successfully.']);

        }catch (\Exception $exception){
            return response()->json([
                'success' => false,
                'errors' => $exception->getMessage()
            ]);
        }
    }
}
