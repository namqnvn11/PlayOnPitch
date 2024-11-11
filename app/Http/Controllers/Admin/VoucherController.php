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
            'price' => 'required|numeric|min:0',
            'release_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:release_date',
            'conditions_apply' => 'required|numeric|min:0',
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
                return response()->json([
                    'success' => false,
                    'message' => 'Voucher not found'
                ]);
            }

            $voucher->block = 1;
            $voucher->save();

            return response()->json([
                'success' => true,
                'message' => 'Voucher '. $voucher->name .' blocked successfully'
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
            $voucher = Voucher::find($id);
            $voucher->block = 0;
            $voucher->save();

            return response()->json([
                'success' => true,
                'message' => 'Voucher '. $voucher->name .' unblocked successfully'
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
        $fromReleaseDate= $request->input('fromReleaseDate');
        $toReleaseDate= $request->input('toReleaseDate');
        $fromExpireDate= $request->input('fromExpireDate');
        $toExpireDate= $request->input('toExpireDate');
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

        if ($fromReleaseDate !== null && $toReleaseDate !== null) {
            $query->whereBetween('release_date', [$fromReleaseDate, $toReleaseDate]);
        }

        if ($fromExpireDate !== null && $toExpireDate !== null) {
            $query->whereBetween('end_date', [$fromExpireDate, $toExpireDate]);
        }

        $vouchers = $query->orderByDesc('created_at')
            ->paginate(10)
            ->appends($request->input());

        $Users = User::all();
        return view('admin.voucher.index', compact('vouchers', 'Users'));
    }
}
