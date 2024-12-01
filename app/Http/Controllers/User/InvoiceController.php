<?php

namespace App\Http\Controllers\User;
use App\Http\Controllers\Controller;
use App\Models\District;
use App\Models\Province;
use App\Models\Reservation;
use App\Models\Yard;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function index($id)
    {
        $reservation = Reservation::with(['user', 'yard'])->find($id);

        if (!$reservation) {
            return redirect()->route('some.error.route')->with('error', 'Hóa đơn không tồn tại!');
        }

        return view('user.invoice.index', compact('reservation'));
    }
}
