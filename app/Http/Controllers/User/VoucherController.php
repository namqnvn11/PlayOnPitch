<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\User_voucher;
use App\Models\Voucher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VoucherController extends Controller
{
    public function index()
    {
        $vouchers = Voucher::where('block', 0)->paginate(10);
        return view('user.voucher.index', compact('vouchers'));
    }

    public function exchangeVoucher(Request $request)
    {
        $user = auth()->user();
        $voucherId = $request->input('voucher_id');

        try {
            DB::beginTransaction();

            $voucher = Voucher::findOrFail($voucherId);

            if ($user->score < $voucher->conditions_apply) {
                DB::rollBack();
                flash()->error("You don't have enough points to redeem this voucher.");
                return redirect()->back();
            }

            $user->score -= $voucher->conditions_apply;
            $user->save();

            User_voucher::create([
                'user_id' => $user->id,
                'voucher_id' => $voucher->id,
            ]);

            DB::commit();

            flash()->success("Voucher redeemed successfully.");
            return redirect()->back();
        } catch (\Exception $e) {
            DB::rollBack();
            flash()->error("An error has occurred:" . $e->getMessage());
            return redirect()->back();
        }
    }
}
