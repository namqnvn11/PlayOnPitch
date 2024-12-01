<?php

namespace App\Http\Controllers\Boss;

use App\Http\Controllers\Controller;
use App\Models\Boss;
use App\Models\Reservation;
use App\Models\Revenue;
use App\Models\Yard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class RevenueController extends Controller
{   public function index(Request $request)
{
    $bossId = Auth::guard('boss')->id();

    $yards = Yard::where('boss_id', $bossId)->get();

    $query = Reservation::whereIn('yard_id', $yards->pluck('id'));

    $filterType = $request->get('filter_type', 'month');
    $filterValue = $request->get('filter_value', Carbon::now()->month);

    switch ($filterType) {
        case 'month':
            $query->whereMonth('reservation_date', $filterValue)
                ->whereYear('reservation_date', Carbon::now()->year);
            break;

        case 'quarter':
            $quarterMonths = $this->getMonthsByQuarter($filterValue);
            $query->whereIn(DB::raw('MONTH(reservation_date)'), $quarterMonths)
                ->whereYear('reservation_date', Carbon::now()->year);
            break;

        case 'year':
            $query->whereYear('reservation_date', $filterValue);
            break;
    }

    $data = $query->join('yards', 'reservations.yard_id', '=', 'yards.id')
        ->selectRaw('yards.yard_name, COUNT(reservations.id) as reservation_count, SUM(reservations.total_price) as total_revenue')
        ->groupBy('yards.yard_name')
        ->orderBy('yards.yard_name', 'asc')
        ->get();

    return view('boss.revenue.index', compact('data'));
}

    private function getMonthsByQuarter($quarter)
    {
        switch ($quarter) {
            case 1:
                return [1, 2, 3];
            case 2:
                return [4, 5, 6];
            case 3:
                return [7, 8, 9];
            case 4:
                return [10, 11, 12];
            default:
                return [];
        }
    }
}
