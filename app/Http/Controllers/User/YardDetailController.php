<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\District;
use App\Models\Province;
use App\Models\Raiting;
use App\Models\Report;
use App\Models\User;
use App\Models\Yard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class YardDetailController extends Controller
{
    public function index($id)
    {
        $District = District::all();
        $Province = Province::all();
        $yard = Yard::find($id);

        $ratings = Raiting::with('User')
            ->where('yard_id', $id)
            ->where('block', 0)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        $User = User::all();
        $averageRating = Raiting::where('yard_id', $id)->avg('point');
        return view('user.yard_detail.index', compact( 'District', 'Province', 'yard', 'ratings', 'User', 'averageRating'));
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

            $rating = new Raiting();

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

    public function report(Request $request){

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

            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            $report = new Report();

            $report->raiting_id = $request->rating_id;
            $report->user_id = $request->user_id;
            $report->comment = $request->comment;
            $report->title = $request->title;
            $report->status = 'Chờ xử lý';
            $report->save();
            $message = 'Thank you for your feedback!';


            $reportCount = Report::where('raiting_id', $request->rating_id)->count();

            if($reportCount >= 5){
                $rating = Raiting::find($request->rating_id);
                if($rating){
                    $rating->block = 1;
                    $rating->save();
                }
            }

            if ($request->ajax()) {
                flash()->success($message);
                return response()->json([
                    'success' => true,
                    'message' => $message,
                    'voucher' => $report
                ], 200);

            }


        }catch (\Exception $e){
            if ($request->ajax()) {
                flash()->error($e->getMessage());
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to process report: ' . $e->getMessage()
                ], 500);
            }

            return redirect()->back()->with(['error' => 'Failed to process report: ' . $e->getMessage()]);
        }
    }
    public function loadMoreRatings($id, Request $request)
    {
        $ratings = Raiting::with('User')
            ->where('yard_id', $id)
            ->orderBy('created_at', 'desc')
            ->paginate(10, ['*'], 'page', $request->page);

        $averageRating = Raiting::where('yard_id', $id)->avg('point');

        $reviews = $ratings->items();
        $hasMorePages = $ratings->hasMorePages();

        return response()->json([
            'reviews' => $reviews,
            'hasMorePages' => $hasMorePages,
            'averageRating' => round($averageRating, 2)
        ]);
    }
}
