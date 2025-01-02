<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Rating;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    function index(){
        $baseUrl = app()->environment('production') ? env('APP_URL') : url('/');
            $ratings = Rating::where('report_count','>=',5)->where('status','pending')->paginate(15)->withPath($baseUrl.'/admin/reported/index');
        return view('admin.reportedRatings.index', compact('ratings'));
    }

    function block(Request $request) {

        $ratingIds= $request->ratingIds;
        if (!$ratingIds) {
            return response()->json([
                'success' => false,
                'message' => 'Please select at least one rating.'
            ]);
        }

        foreach ($ratingIds as $ratingId) {
            $rating=Rating::find($ratingId);
            $rating->status='blocked';
            $rating->save();
            $reports= $rating->Reports;
            foreach ($reports as $report) {
               $report->status='reported';
               $report->save();
            }
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
        foreach ($ratingIds as $ratingId) {
            $rating= Rating::find($ratingId);
            $rating->status='approved';
            $rating->report_count=0;
            $rating->block=false;
            $rating->save();

            $reports = $rating->Reports;
            foreach ($reports as $report) {
                $report->status='rejected';
                $report->save();
            }
        }
        return response()->json([
            'success' => true,
            'message' => 'Ratings has been unblocked successfully.'
        ]);
    }

    //ratingId
    function getReports($id) {
        $currentRating = Rating::with(['Reports.User'])->find($id);

        if (!$currentRating) {
            return response()->json(
                [    'success' => false,
                    'message' => 'Rating not found'
                ]);
        }

        // Nhóm các reports theo user
        $groupedReports = $currentRating->Reports
            ->where('status', 'pending')
            ->groupBy('user_id')->map(function ($reports, $userId) {
            return [
                'user' => $reports->first()->User,
                'reports' => $reports,
            ];
        });

        return response()->json([
            'success' => true,
            'groupedReports' => $groupedReports->toArray(),
        ]);
    }


}
