<?php

namespace App\Http\Controllers\User;
use App\Http\Controllers\Controller;
use App\Models\District;
use App\Models\Invoice;
use App\Models\Province;
use App\Models\Reservation;
use App\Models\Yard;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{

    //invoiceId
    public function index($id)
    {
        $invoice= Invoice::find($id);
        $reservation= Reservation::find($invoice->reservation_id);
        return view('user.invoice.index', compact('reservation','invoice'));
    }
}
