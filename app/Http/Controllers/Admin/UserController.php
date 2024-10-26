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
            $user = new User();
            $user->full_name = $request->input('full_name');
            $user->email = $request->input('email');
            $user->password = Hash::make($request->input('password'));
            $user->phone = $request->input('phone');
            $user->address = $request->input('address');
            $user->district_id = $request->input('district_id');
            $user->booking_count = 0;
            $user->score = 0;
            $user->block = 0;
            $user->created_at = now();

            $user->save();

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'User created successfully',
                    'user' => $user
                ], 201);
            }

            // Nếu không phải AJAX, chuyển hướng về danh sách người dùng
            return redirect()->route('admin.user.index')->with('message', 'User created successfully');

        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to create user: ' . $e->getMessage()
                ], 500);
            }

            return redirect()->route('admin.user.index')->with('error', 'Failed to create user: ' . $e->getMessage());
        }
    }


    public function block($id)
    {
        try {
            $user = User::find($id);

            // Kiểm tra nếu người dùng tồn tại
            if (!$user) {
                return redirect()->route('admin.user.index')->with('error', 'User not found.');
            }

            // Cập nhật trạng thái block
            $user->block = 1;
            $user->save();

            // Chuyển hướng về trang danh sách người dùng với thông báo thành công
            return redirect()->route('admin.user.index')->with('message', 'User blocked successfully');

        } catch (\Exception $e) {
            // Chuyển hướng về trang danh sách người dùng với thông báo lỗi
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


}
