<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\District;
use App\Models\Province;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function index()
    {
        $users= User::orderby('created_at')->where('block',0)->paginate(10);
        $District = District::all();
        $Province = Province::all();
        return view('admin.user.index', compact('users', 'District', 'Province'));
    }

    public function store(Request $request)
    {
        $passwordValidateRule= ($request->has('id') && $request->input('id') != null) ? 'nullable' : 'required';
        $validator = Validator::make($request->all(), [
            'full_name' => 'required',
            'email' => 'required|email|unique:users,email,' . $request->input('id'),
            'password'=> $passwordValidateRule . '|min:8',
            'phone' => ['required', 'string', 'regex:/^((\+84|0)(\d{9,10}))|((0\d{2,3})\d{7,8})$/'],
            'address' => 'required',
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
                $user = User::findOrFail($request->input('id'));
                $message = 'User updated successfully';
            } else {
                $user = new User();
                $user->booking_count = 0;
                $user->score = 0;
                $user->block = 0;
                $user->created_at = now();
                $message = 'User created successfully';
            }

            if ($request->filled('password')) {
                $user->password = Hash::make($request->input('password'));
            }

            $user->full_name = $request->input('full_name');
            $user->email = $request->input('email');
            $user->phone = $request->input('phone');
            $user->address = $request->input('address');
            $user->district_id = $request->input('district');

            $user->save();

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => $message,
                    'user' => $user
                ], 200);
            }

            return redirect()->route('admin.user.index')->with('message', $message);

        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to process user: ' . $e->getMessage()
                ], 500);
            }

            return redirect()->route('admin.user.index')->with('error', 'Failed to process user: ' . $e->getMessage());
        }
    }



    public function block($id)
    {
        try {
            $user = User::find($id);

            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'User not found'
                ]);
            }

            $user->block = 1;
            $user->save();

            return response()->json([
                'success' => true,
                'message' => $user->full_name . ' blocked successfully'
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
            $user = User::find($id);
            $user->block = 0;
            $user->save();

            return response()->json([
                'success' => true,
                'message' => $user->full_name . ' unblocked successfully'
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
        $response = User::findOrFail($id);
        $district=null;
        if ($response->district_id&&$response->district_id!==0) {
            $district = District::findOrFail($response->district_id);
        }

        if($response){
            return response()->json([
                'success'   => true,
                'data'      => $response,
                'district' => $district,
                'province' => $district->province??null,
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
        $query = User::query();

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
        if ($request->asc!==null && $request->asc === 'false') {
            $query->orderByRaw("SUBSTRING_INDEX(full_name, ' ', -1) DESC");
        }

        $query->orderByRaw("SUBSTRING_INDEX(full_name, ' ', -1) ASC");

        $users = $query->paginate(10)->appends($request->input());
        $District = District::all();
        $Province = Province::all();

        return view('admin.user.index', compact('users', 'District', 'Province'));
    }

    function  resetPassword(request $request,$id){

            $validator= Validator::make($request->all(),['new_password'=>'required|min:8']);
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
            $user= User::find($id);
            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'User not found'
                ]);
            }
            $user->password = Hash::make($request->new_password);
            $user->save();
            return response()->json([
                'success' => true,
                'message' => $user->full_name.'\'password reset successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }

    }
}
