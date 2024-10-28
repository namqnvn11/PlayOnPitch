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
            'end_date' => 'required',
            'conditions_apply' => 'required',
            'user_id' => 'required',
        ]);

        try {
            // Kiểm tra xem có 'id' trong request không
            if ($request->has('id') && $request->input('id') != null) {
                // Tìm voucher theo 'id' để cập nhật
                $voucher = Voucher::findOrFail($request->input('id'));
                $message = 'Voucher updated successfully';
            } else {
                // Không có 'id' => Tạo mới
                $voucher = new Voucher();
                $voucher->block = 0;
                $voucher->created_at = now();
                $message = 'Voucher created successfully';
            }

            // Cập nhật các thông tin từ request
            $voucher->name = $request->input('name');
            $voucher->price = $request->input('price');
            $voucher->release_date = $request->input('release_date');
            $voucher->end_date = $request->input('end_date');
            $voucher->conditions_apply = $request->input('conditions_apply');
            $voucher->user_id = $request->input('user_id');

            $voucher->save();

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => $message,
                    'voucher' => $voucher
                ], 200);
            }

            return redirect()->route('admin.voucher.index')->with('message', $message);

        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to process voucher: ' . $e->getMessage()
                ], 500);
            }

            return redirect()->route('admin.voucher.index')->with('error', 'Failed to process voucher: ' . $e->getMessage());
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
            $response = Voucher::findOrFail($id);

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
