<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Voucher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class VoucherController extends Controller
{
    public function index()
    {
        $vouchers = Voucher::where('block', 0)->paginate(10);
        $Users = User::all();
        return view('admin.voucher.index', compact('vouchers', 'Users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'price' => 'required',
            'release_date' => 'required',
            'end_date' => 'required|',
            'conditions_apply' => 'required',
            'user_id' => 'required',
        ]);

        try {
            $voucher = new Voucher();
            $voucher->name = $request->input('name');
            $voucher->price = $request->input('price');
            $voucher->release_date = $request->input('release_date');
            $voucher->end_date = $request->input('end_date');
            $voucher->conditions_apply = $request->input('conditions_apply');
            $voucher->user_id = $request->input('user_id');
            $voucher->block = 0;
            $voucher->created_at = now();

            $voucher->save();

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'User created successfully',
                    'voucher' => $voucher
                ], 201);
            }

            // Nếu không phải AJAX, chuyển hướng về danh sách người dùng
            return redirect()->route('admin.voucher.index')->with('message', 'User created successfully');

        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to create user: ' . $e->getMessage()
                ], 500);
            }

            return redirect()->route('admin.voucher.index')->with('error', 'Failed to create voucher: ' . $e->getMessage());
        }
    }


    public function block($id)
    {
        try {
            $voucher = Voucher::find($id);

            if (!$voucher) {
                return redirect()->route('admin.voucher.index')->with('error', 'Voucher not found.');
            }

            // Cập nhật trạng thái block
            $voucher->block = 1;
            $voucher->save();

            return redirect()->route('admin.voucher.index')->with('message', 'Voucher blocked successfully');

        } catch (\Exception $e) {
            return redirect()->route('admin.voucher.index')->with('error', 'Failed to block Voucher: ' . $e->getMessage());
        }
    }

    public function unblock($id)
    {
        try {
            $voucher = Voucher::find($id);
            $voucher->block = 0;
            $voucher->save();

            return redirect()->route('admin.voucher.index')->with('message', 'Voucher UnBlock successfully');

        }catch(\Exception $e)
        {

            return redirect()->route('admin.$voucher.index')->with('error', 'Failed to UnBlock user: ' . $e->getMessage());

        }

    }

    public function detail(Request $request, $id)
    {
        try {
            $voucher = Voucher::findOrFail($id);

            if ($request->ajax()) {

                return response()->json([
                    'success' => true,
                    'message' => 'Voucher details retrieved successfully',
                    'voucher' => $voucher
                ], 200);
            }

            return view('admin.voucher.detail', compact('voucher'));

        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to retrieve voucher: ' . $e->getMessage()
                ], 500);
            }

            return redirect()->route('admin.voucher.index')->with('error', 'Failed to retrieve voucher: ' . $e->getMessage());
        }
    }
}
