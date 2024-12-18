<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Rating;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    function index(){
        $ratings = Rating::whereHas('reports', function ($query) {
            $query->selectRaw('rating_id, COUNT(*) as report_count')
                ->groupBy('rating_id')
                ->havingRaw('COUNT(*) >= 5');
        })->get();
        return view('admin.reportedRatings.index', compact('ratings'));
    }

    function block(Request $request) {
//  "ratingIds" => array:3 [
//            0 => "11"
//    1 => "12"
//    2 => "13"

        $ratingIds= $request->ratingIds;
        if (!$ratingIds) {
            return response()->json([
                'success' => false,
                'message' => 'Please select at least one rating.'
            ]);
        }

        foreach ($ratingIds as $ratingId) {

        }
        return response()->json([
            'success' => true,
            'message' => 'Ratings blocked successfully.'
        ]);
    }

    function unblock(Request $request) {
        $ratingIds= $request->ratingIds;
        if (!$ratingIds) {
            return response()->json([
                'success' => false,
                'message' => 'Please select at least one rating.'
            ]);
        }
        return response()->json([
            'success' => true,
            'message' => 'Ratings has been unblocked successfully.'
        ]);
    }
}
