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

        $validator = Validator::make($request->all(), [
            'full_name' => 'required',
            'email' => 'required|email|unique:users,email,' . $request->input('id'),
            'password' => 'required|min:8',
            'phone' => 'required',
            'address' => 'required',
            'district_id' => 'required',
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


            $user->full_name = $request->input('full_name');
            $user->email = $request->input('email');
            $user->password = Hash::make($request->input('password'));
            $user->phone = $request->input('phone');
            $user->address = $request->input('address');
            $user->district_id = $request->input('district_id');

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
                return redirect()->route('admin.user.index')->with('error', 'User not found.');
            }


            $user->block = 1;
            $user->save();

            return redirect()->route('admin.user.index')->with('message', 'User blocked successfully');

        } catch (\Exception $e) {
            return redirect()->route('admin.user.index')->with('error', 'Failed to block user: ' . $e->getMessage());
        }
    }

    public function unblock($id)
    {
        try {
            $user = User::find($id);
            $user->block = 0;
            $user->save();

            return redirect()->route('admin.user.index')->with('message', 'User UnBlock successfully');

        }catch(\Exception $e)
        {

            return redirect()->route('admin.user.index')->with('error', 'Failed to UnBlock user: ' . $e->getMessage());

        }

    }

    public function detail(Request $request, $id)
    {
        $response = User::findOrFail($id);

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

        $users = $query->orderByDesc('created_at')
            ->paginate(10)
            ->appends($request->input());
        $District = District::all();
        $Province = Province::all();

        return view('admin.user.index', compact('users', 'District', 'Province'));
    }

}
