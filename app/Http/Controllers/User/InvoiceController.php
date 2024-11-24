<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\District;
use App\Models\Province;
use App\Models\Yard;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function index($id)
    {
        $District = District::all();
        $Province = Province::all();

        $yard = Yard::with('boss')->find($id); // Lấy sân dựa theo ID

        if (!$yard) {
            return redirect()->route('some.error.route')->with('error', 'Sân không tồn tại!');
        }

        return view('user.invoice.index', compact('yard', 'District', 'Province'));
    }

}
