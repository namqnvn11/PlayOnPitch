<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Boss;
use App\Models\District;
use App\Models\Province;
use App\Models\Rating;
use App\Models\Report;
use App\Models\User;
use App\Models\Yard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class YardDetailController extends Controller
{
    public function index($id)
    {
        $District = District::all();
        $Province = Province::all();

        $boss = Boss::find($id);
        $firstYard= $boss->Yards()->first();

        $ratings = Rating::with('User')
            ->where('boss_id', $firstYard->id)
            ->where('block', 0)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        $User = User::all();
        $averageRating = Rating::where('boss_id', $firstYard->id)->avg('point');
        return view('user.yard_detail.index', compact( 'District', 'Province', 'ratings', 'User', 'averageRating', 'boss'));
    }

    public function rating(Request $request){
        $request->validate([
            'point' => 'required',
            'comment' => 'required',
        ]);
        try {
            $user_id = $request->user_id;
            $yard_id = $request->yard_id;
            $point = $request->point;
            $comment = $request->comment;

            $rating = new Rating();

            $rating->user_id = $user_id;
            $rating->yard_id = $yard_id;
            $rating->point = $point;
            $rating->block = 0;
            $rating->comment = $comment;

            $rating->save();

            flash()->success('Thank you for your feedback!');
            return redirect()->back();

        }catch (\Exception $e){

            flash()->error($e->getMessage());
            return redirect()->back();
        }
    }

    public function report(Request $request)
    {
        if (!Auth::check()) {


            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'You need to log in to report!'
                ], 403);
            }
            flash()->error('You need to log in to report!');
            return redirect()->back();
        }

        // Validator xác thực input
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'comment' => 'required|string|min:5',
        ]);

        if ($validator->fails()) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'errors' => $validator->errors()
                ], 422);
            }

            flash()->error('Please provide correct and complete information.');
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            // Tạo report mới
            $report = new Report();
            $report->raiting_id = $request->rating_id;
            $report->user_id = Auth::id(); // Lấy user_id từ Auth
            $report->comment = $request->comment;
            $report->title = $request->title;
            $report->status = 'Pending review';
            $report->save();

            $message = 'Thank you for submitting your report!';

            // Đếm số lượng report cho rating
            $reportCount = Report::where('rating_id', $request->rating_id)->count();

            if ($reportCount >= 5) {
                $rating = Rating::find($request->rating_id);
                if ($rating) {
                    $rating->block = 1; // Block rating khi có >= 5 reports
                    $rating->save();
                }
            }

            // Phản hồi cho AJAX
            if ($request->ajax()) {
                flash()->success($message);
                return response()->json([
                    'success' => true,
                    'message' => $message,
                    'report' => $report
                ], 200);
            }

            // Flash message thành công
            flash()->success($message);
            return redirect()->back();

        } catch (\Exception $e) {
            if ($request->ajax()) {
                flash()->error('An error occurred: ' . $e->getMessage());
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to process report: ' . $e->getMessage()
                ], 500);
            }

            flash()->error('An error occurred: ' . $e->getMessage());
            return redirect()->back();
        }
    }

    public function loadMoreRatings($id, Request $request)
    {
        $ratings = Rating::with('User')
            ->where('boss_id', $id)
            ->orderBy('created_at', 'desc')
            ->paginate(10, ['*'], 'page', $request->page);

        $averageRating = Rating::where('boss_id', $id)->avg('point');

        $reviews = $ratings->items();
        $hasMorePages = $ratings->hasMorePages();

        return response()->json([
            'reviews' => $reviews,
            'hasMorePages' => $hasMorePages,
            'averageRating' => round($averageRating, 2)
        ]);
    }
}
