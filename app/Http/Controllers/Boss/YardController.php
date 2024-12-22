<?php

namespace App\Http\Controllers\Boss;

use App\Http\Controllers\Controller;
use App\Models\Boss;
use App\Models\District;
use App\Models\PriceTimeSetting;
use App\Models\Province;
use App\Models\User;
use App\Models\Yard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class YardController extends Controller
{
    public function index()
    {
        $currentBoss = Auth::guard('boss')->user();
        $yards = Yard::where('block', 0)->orderBy('yard_name', 'asc')
            ->paginate(10);
        $District = District::all();
        $Province = Province::all();
        return view('boss.yard.index', compact('yards', 'District', 'Province', 'currentBoss'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'yard_name' => [
                'required',
                'string',
                //kiểm tra có trùng tên với các sân có cùng boss id và chỉ xét các sân không bị block
                Rule::unique('yards')->ignore($request->id)->where(function ($query) use ($request) {
                    return $query->where('boss_id', Auth::guard('boss')->id())
                        ->where('block', false);
                })
            ],
            'yard_type' => 'required',
//            'description' => 'required',
            'district' => 'required|exists:districts,id',
            'province' => 'required|exists:provinces,id',
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

            if ($request->has('id') && $request->input('id') != null) {

                $yard = Yard::findOrFail($request->input('id'));
                $message = 'Yard updated successfully';
            } else {

                $yard = new Yard();
                $yard->boss_id = Auth::guard('boss')->id();
                $yard->block = 0;
                $yard->created_at = now();
                $message = 'Yard created successfully';
            }


            $yard->yard_name = $request->input('yard_name');
            $yard->yard_type = $request->input('yard_type');
//            $yard->description = $request->input('description');
            $yard->district_id = $request->input('district');

            $yard->save();

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => $message,
                    'yard' => $yard
                ], 200);
            }

            return redirect()->route('boss.yard.index')->with('message', $message);

        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to process yard: ' . $e->getMessage()
                ], 500);
            }

            return redirect()->route('boss.yard.index')->with('error', 'Failed to process yard: ' . $e->getMessage());
        }
    }

    function description(Request $request)
    {
       $validator= Validator::make(request()->all(), [
           'description' => ['required','max:255'],
       ]);

        if ($validator->fails()) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => $validator->errors()
                ]);
            }
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            $currentBoss = Auth::guard('boss')->user();
            $currentBoss->description = $request->input('description');
            $currentBoss->save();
            return response()->json([
                'success' => true,
                'message' => 'Yards description updated successfully'
            ]);
        }catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function block($id)
    {

        try {
            $yard = Yard::find($id);

            if (!$yard) {
                return response()->json([
                    'success' => false,
                    'message' => 'Yard not found'
                ]);
            }

            $yard->block = 1;
            $yard->save();

            return response()->json([
                'success' => true,
                'message' => $yard->yard_name . ' blocked successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function unblock($id)
    {
        try {
            $yard = Yard::find($id);

            //kiểm tra nếu mở khóa thì có bị trùng tên với sân hiện tại
            $activeYardList = Yard::where('boss_id', Auth::guard('boss')->id())
                ->where('block', 0)->get();
            foreach ($activeYardList as $activeYard) {
                if ($activeYard->yard_name === $yard->yard_name) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Sân số ' . $yard->yard_name . ' already exist'
                    ]);
                }
            }
            $yard->block = 0;
            $yard->save();
            return response()->json([
                'success' => true,
                'message' => $yard->yard_name . ' unblocked successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }

    }

    public function detail(Request $request, $id)
    {
        $response = Yard::findOrFail($id);
        $district = District::findOrFail($response->district_id);
        if ($response) {
            return response()->json([
                'success' => true,
                'data' => $response,
                'district' => $district,
                'province' => $district->province,
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => "Saving failed.",
        ]);

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

    public function search(Request $request)
    {

        $currentBoss = Auth::guard('boss')->user();
        $block = $request->input('block', 'active');
        $query = Yard::query();
        $query->where('boss_id', $currentBoss->id);

        if ($request->searchText !== null) {
            $searchText = $request->input('searchText');
            $query->where(function ($q) use ($searchText) {
                $q->where('yard_name', 'like', '%' . $searchText . '%');
            });
        }

        if ($block === 'active') {
            $query->where('block', false);
        } elseif ($block === 'blocked') {
            $query->where('block', true);
        }

        $yards = $query->orderByDesc('created_at')
            ->paginate(10)
            ->appends($request->input());
        $District = District::all();
        $Province = Province::all();

        return view('boss.yard.index', compact('yards', 'District', 'Province','currentBoss'));
    }


}
