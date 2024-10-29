<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\District;
use App\Models\Boss;
use Flasher\Laravel\Facade\Flasher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class BossController extends Controller
{
    public function index()
    {
        $bosses = Boss::where('block', 0)->paginate(10);
        $District = District::all();
        return view('admin.boss.index', compact('bosses', 'District'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:bosses|unique:admins',
            'password' => 'required|min:8',
            'full_name' => 'required',
            'phone' => 'required|min:10',
            'company_name' => 'required',
            'company_address' => 'required',
            'status' => 'required',
            'district_id' => 'required',
        ]);

        try {
            // Kiểm tra xem có 'id' trong request không
            if ($request->has('id') && $request->input('id') != null) {
                // Tìm boss theo 'id' để cập nhật
                $boss = Boss::findOrFail($request->input('id'));
                $message = 'Boss updated successfully';
            } else {
                // Không có 'id' => Tạo mới
                $boss = new Boss();
                $boss->block = 0;
                $boss->created_at = now();
                $message = 'Boss created successfully';
            }

            // Cập nhật các thông tin từ request
            $boss->email = $request->input('email');
            $boss->password = Hash::make($request->input('password'));
            $boss->full_name = $request->input('full_name');
            $boss->phone = $request->input('phone');
            $boss->company_name = $request->input('company_name');
            $boss->company_address = $request->input('company_address');
            $boss->status = $request->input('status');
            $boss->district_id = $request->input('district_id');

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
                flash()->error('Failed to precess boss');
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to process boss: ' . $e->getMessage()
                ], 500);
            }

            return redirect()->route('admin.boss.index')->with('error', 'Failed to process boss: ' . $e->getMessage());
        }
    }



    public function block($id)
    {
        try {
            $boss = Boss::find($id);

            if (!$boss) {
                return redirect()->route('admin.boss.index')->with('error', 'Boss not found.');
            }

            // Cập nhật trạng thái block
            $boss->block = 1;
            $boss->save();

            return redirect()->route('admin.boss.index')->with('message', 'Boss blocked successfully');

        } catch (\Exception $e) {
            return redirect()->route('admin.boss.index')->with('error', 'Failed to block Boss: ' . $e->getMessage());
        }
    }

    public function unblock($id)
    {
        try {
            $boss = Boss::find($id);
            $boss->block = 0;
            $boss->save();

            return redirect()->route('admin.boss.index')->with('message', 'Boss UnBlock successfully');

        }catch(\Exception $e)
        {

            return redirect()->route('admin.$boss.index')->with('error', 'Failed to UnBlock user: ' . $e->getMessage());

        }

    }

    public function detail(Request $request, $id)
    {
        $response = Boss::findOrFail($id);

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
