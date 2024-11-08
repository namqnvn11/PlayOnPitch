<?php

namespace App\Http\Controllers\Boss;

use App\Http\Controllers\Controller;
use App\Models\Boss;
use App\Models\District;
use App\Models\Province;
use App\Models\User;
use App\Models\Yard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class YardController extends Controller
{
    public function index()
    {
        $currenBoss= Auth::guard('boss')->user();
        $yards = Yard::where('block', 0)
                        ->where('boss_id',$currenBoss->id)
                        ->orderBy('yard_name', 'asc')
                        ->paginate(10);
        $District = District::all();
        $Province = Province::all();
        return view('boss.yard.index', compact('yards', 'District', 'Province'));
    }

    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'yard_name' => [
                'required',
                'unique:yards,yard_name' . ($request->has('id') ? ',' . $request->id : ''),
            ],
            'yard_type' => 'required',
            'description' => 'required',
            'district_id' => 'required|exists:districts,id',
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
            $yard->description = $request->input('description');
            $yard->district_id = $request->input('district_id');

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




    public function block($id)
    {
        try {
            $yard = Yard::find($id);

            if (!$yard) {
                return redirect()->route('boss.yard.index')->with('error', 'Yard not found.');
            }


            $yard->block = 1;
            $yard->save();

            return redirect()->route('boss.yard.index')->with('message', 'Yard blocked successfully');

        } catch (\Exception $e) {
            return redirect()->route('boss.yard.index')->with('error', 'Failed to block Yard: ' . $e->getMessage());
        }
    }

    public function unblock($id)
    {
        try {
            $yard = Yard::find($id);
            $yard->block = 0;
            $yard->save();

            return redirect()->route('boss.yard.index')->with('message', 'Yard UnBlock successfully');

        }catch(\Exception $e)
        {

            return redirect()->route('boss.$yard.index')->with('error', 'Failed to UnBlock user: ' . $e->getMessage());

        }

    }

    public function detail(Request $request, $id)
    {
        $response = Yard::findOrFail($id);

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

    public function search(Request $request){

        $currenBoss= Auth::guard('boss')->user();
        $block= $request->input('block','active');
        $query = Yard::query();
        $query->where('boss_id',$currenBoss->id);

        if ($request->searchText !== null) {
            $searchText = $request->input('searchText');
            $query->where(function($q) use ($searchText) {
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

        return view('boss.yard.index', compact('yards', 'District', 'Province'));
    }
}
