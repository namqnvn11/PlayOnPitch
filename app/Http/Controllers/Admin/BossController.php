<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\District;
use App\Models\Boss;
use App\Models\Province;
use Flasher\Laravel\Facade\Flasher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
class BossController extends Controller
{
    public function index()
    {
        $bosses = Boss::where('block', 0)->paginate(10);
        $District = District::all();
        $Province = Province::all();
        return view('admin.boss.index', compact('bosses',  'Province', 'District'));
    }

    public function store(Request $request)
    {
        $passwordValidateRule= ($request->has('id') && $request->input('id') != null) ? 'nullable' : 'required';
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|unique:bosses,email,' . $request->input('id'),
            'password'=> $passwordValidateRule . '|min:8',
            'full_name' => 'required',
            'phone' => ['required', 'string', 'regex:/^((\+84|0)(\d{9,10}))|((0\d{2,3})\d{7,8})$/'],
            'company_name' => 'required',
            'company_address' => 'required',
            'status' => 'required',
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
            if ($request->has('id') && $request->input('id') != null) {
                $boss = Boss::findOrFail($request->input('id'));
                $message = 'Boss updated successfully';
            } else {
                $boss = new Boss();
                $boss->block = 0;
                $boss->created_at = now();
                $message = 'Boss created successfully';
            }

            $boss->email = $request->input('email');

            if ($request->filled('password')) {
                $boss->password = Hash::make($request->input('password'));
            }

            $boss->full_name = $request->input('full_name');
            $boss->phone = $request->input('phone');
            $boss->company_name = $request->input('company_name');
            $boss->company_address = $request->input('company_address');
            $boss->status = $request->input('status');
            $boss->district_id = $request->input('district');
            $boss->save();

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => $message,
                    'boss' => $boss
                ], 200);
            }

            return redirect()->route('admin.boss.index')->with('message', $message);

        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to process boss'
                ], 500);
            }

            return redirect()->route('admin.boss.index')->with('error', 'Failed to process boss');
        }
    }




    public function block($id)
    {
        try {
            $boss = Boss::find($id);

            if (!$boss) {
                return  response()->json([
                    'success' => false,
                    'message' => 'Boss not found'
                ]);
            }

            $boss->block = 1;
            $boss->save();

            return response()->json([
                'success' => true,
                'message' => $boss->full_name . ' blocked successfully.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ],301);
        }
    }

    public function unblock($id)
    {
        try {
            $boss = Boss::find($id);
            $boss->block = 0;
            $boss->save();

            return response()->json([
                'success' => true,
                'message' => $boss->full_name . ' unblocked successfully.'
            ]);
        }catch(\Exception $e)
        {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }

    }

    public function detail(Request $request, $id)
    {
        $response = Boss::findOrFail($id);
        $district = District::findOrFail($response->district_id);
        if($response){
            return response()->json([
                'success'   => true,
                'data'      => $response,
                'district' => $district,
                'province' => $district->province,
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
        $block= $request->input('block','active');
        $status= $request->input('filterStatus','all');
        $query = Boss::query();
        if ($request->searchText !== null) {
            $searchText = $request->input('searchText');
            $query->where(function($q) use ($searchText) {
                $q->where('full_name', 'like', '%' . $searchText . '%')
                    ->orWhere('email', 'like', '%' . $searchText . '%');
            });
        }

        if ($block === 'active') {
            $query->where('block', false);
        } elseif ($block === 'blocked') {
            $query->where('block', true);
        }

        if ($status === 'new') {
            $query->where('status', true);
        } elseif ($status === 'old') {
            $query->where('status', false);
        }

        $bosses = $query->orderByDesc('created_at')
            ->paginate(10)
            ->appends($request->input());
        $District = District::all();
        $Province = Province::all();

        return view('admin.boss.index', compact('bosses', 'District', 'Province'));
    }
}
