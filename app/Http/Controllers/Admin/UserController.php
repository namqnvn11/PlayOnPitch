<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\District;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::where('block', 0)->paginate(10);
        $District = District::all();
        return view('admin.user.index', compact('users', 'District'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'full_name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8',
            'phone' => 'required',
            'address' => 'required',
            'district_id' => 'required',
        ]);

        try {
            // Kiểm tra xem có 'id' trong request không
            if ($request->has('id') && $request->input('id') != null) {

                $user = User::findOrFail($request->input('id'));
                $message = 'User updated successfully';
            } else {
                // Không có 'id' => Tạo mới
                $user = new User();
                $user->booking_count  = 0;
                $user->score = 0;
                $user->block = 0;
                $user->created_at = now();
                $message = 'User created successfully';
            }

            // Cập nhật các thông tin từ request
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

            // Cập nhật trạng thái block
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


}
