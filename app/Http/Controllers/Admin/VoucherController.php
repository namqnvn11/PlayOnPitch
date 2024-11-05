<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\District;
use App\Models\Province;
use App\Models\User;
use App\Models\Voucher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

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

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'price' => 'required|numeric',
            'release_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:release_date',
            'conditions_apply' => 'required',
            'user_id' => 'required|exists:users,id',
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

                $voucher = Voucher::findOrFail($request->input('id'));
                $message = 'Voucher updated successfully';
            } else {

                $voucher = new Voucher();
                $voucher->block = 0;
                $voucher->created_at = now();
                $message = 'Voucher created successfully';
            }


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
    public function search(Request $request){

        $block= $request->input('block','active');
        $fromDate= $request->input('fromDate');
        $toDate= $request->input('toDate');
        $searchText = $request->input('searchText');
        $query = Voucher::query();

        if ($request->searchText !== null) {
            $query->where(function($q) use ($searchText) {
                $q->where('name', 'like', '%' . $searchText . '%');
            });
        }

        if ($block === 'active') {
            $query->where('block', false);
        } elseif ($block === 'blocked') {
            $query->where('block', true);
        }

        if ($fromDate !== null && $toDate !== null) {
            $query->whereBetween('release_date', [$fromDate, $toDate]);
        }

        $vouchers = $query->orderByDesc('created_at')
            ->paginate(10)
            ->appends($request->input());

        $Users = User::all();
        return view('admin.voucher.index', compact('vouchers', 'Users'));
    }
}
