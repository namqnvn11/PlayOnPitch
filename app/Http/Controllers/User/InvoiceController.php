<?php

namespace App\Http\Controllers\User;
use App\Http\Controllers\Controller;
use App\Models\Boss;
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
        $reservation= $invoice->Reservation;
        $yardSchedules= $reservation->YardSchedules;
        // Group theo yard_id
        $groupedSchedules = $yardSchedules->groupBy('yard_id');
        $boss= $reservation->YardSchedules->first()->Yard->Boss;
        return view('user.invoice.index', compact('reservation','invoice','boss','groupedSchedules'));
    }
}
