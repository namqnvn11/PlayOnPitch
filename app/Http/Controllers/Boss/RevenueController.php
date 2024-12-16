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

    // Lấy tất cả các yard của boss hiện tại
    $yards = Yard::where('boss_id', $bossId)->get();

    // Bắt đầu query để lấy dữ liệu Reservation thông qua bảng yard_schedule
    $query = Reservation::join('yard_schedules', 'reservations.id', '=', 'yard_schedules.reservation_id')
        ->join('yards', 'yard_schedules.yard_id', '=', 'yards.id')
        ->whereIn('yards.id', $yards->pluck('id'))
        ->where('reservations.payment_status', 'success');

    // Lọc dữ liệu theo loại filter (month, quarter, year)
    $filterType = $request->get('filter_type', 'month');
    $filterValue = $request->get('filter_value', Carbon::now()->month);

    switch ($filterType) {
        case 'month':
            $query->whereMonth('reservations.reservation_date', $filterValue)
                ->whereYear('reservations.reservation_date', Carbon::now()->year);
            break;

        case 'quarter':
            $quarterMonths = $this->getMonthsByQuarter($filterValue);
            $query->whereIn(DB::raw('MONTH(reservations.reservation_date)'), $quarterMonths)
                ->whereYear('reservations.reservation_date', Carbon::now()->year);
            break;

        case 'year':
            $query->whereYear('reservations.reservation_date', $filterValue);
            break;
    }

    // Lấy dữ liệu tổng hợp: yard_name, số lượng đặt sân và tổng doanh thu
    $data = $query->selectRaw('
            yards.yard_name as yard_name,
            COUNT(reservations.id) as reservation_count,
            SUM( yard_schedules.price_per_hour) as total_revenue
        ')
        ->groupBy('yards.yard_name')
        ->orderBy('yards.yard_name', 'asc')
        ->get();

    // Trả về view với dữ liệu đã tổng hợp
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
