<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Image;
use App\Models\User;
use App\Models\Voucher;
use App\Services\Base64FileServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class VoucherController extends Controller
{

    public function __construct(Base64FileServiceProvider $base64Service)
    {
        $this->base64Service = $base64Service;
    }
    public function index()
    {
        $baseUrl = app()->environment('production') ? env('APP_URL') : url('/');
        $vouchers = Voucher::where('block', 0)->paginate(10)->withPath($baseUrl.'/admin/voucher/index');
        $Users = User::all();
        return view('admin.voucher.index', compact('vouchers', 'Users'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'price' => 'required|numeric|min:0',
            'release_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:release_date',
            'conditions_apply' => 'required|numeric|min:0',
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

            if ($request->has('id') && $request->input('id') != null) {

                $voucher = Voucher::findOrFail($request->input('id'));
                $message = 'Voucher updated successfully';
            } else {

                $voucher = new Voucher();
                $voucher->block = 0;
                $voucher->created_at = now();
                $message = 'Voucher created successfully';
            }


            $voucher->name = $request->input('name');
            $voucher->price = $request->input('price');
            $voucher->release_date = $request->input('release_date');
            $voucher->end_date = $request->input('end_date');
            $voucher->conditions_apply = $request->input('conditions_apply');

            $voucher->save();

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => $message,
                    'voucher' => $voucher
                ], 200);
            }

            return redirect()->route('admin.voucher.index')->with('message', $message);

        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to process voucher: ' . $e->getMessage()
                ], 500);
            }

            return redirect()->route('admin.voucher.index')->with('error', 'Failed to process voucher: ' . $e->getMessage());
        }
    }




    public function block($id)
    {
        try {
            $voucher = Voucher::find($id);

            if (!$voucher) {
                return response()->json([
                    'success' => false,
                    'message' => 'Voucher not found'
                ]);
            }

            $voucher->block = 1;
            $voucher->save();

            return response()->json([
                'success' => true,
                'message' => 'Voucher '. $voucher->name .' blocked successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function unblock($id)
    {
        try {
            $voucher = Voucher::find($id);
            $voucher->block = 0;
            $voucher->save();

            return response()->json([
                'success' => true,
                'message' => 'Voucher '. $voucher->name .' unblocked successfully'
            ]);
        }catch(\Exception $e)
        {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }

    }

    public function detail(Request $request, $id)
    {
            $response = Voucher::findOrFail($id);

            if($response){
                return response()->json([
                    'success'   => true,
                    'data'      => $response,
                ]);
            }

            return response()->json([
                'success'   => false,
                'message'   => "Saving failed.",
            ]);

    }
    public function search(Request $request){

        $block= $request->input('block','active');
        $fromReleaseDate= $request->input('fromReleaseDate');
        $toReleaseDate= $request->input('toReleaseDate');
        $fromExpireDate= $request->input('fromExpireDate');
        $toExpireDate= $request->input('toExpireDate');
        $searchText = $request->input('searchText');
        $query = Voucher::query();

        if ($request->searchText !== null) {
            $query->where(function($q) use ($searchText) {
                $q->where('name', 'like', '%' . $searchText . '%');
            });
        }

        if ($block === 'active') {
            $query->where('block', false);
        } elseif ($block === 'blocked') {
            $query->where('block', true);
        }

        if ($fromReleaseDate !== null && $toReleaseDate !== null) {
            $query->whereBetween('release_date', [$fromReleaseDate, $toReleaseDate]);
        }

        if ($fromExpireDate !== null && $toExpireDate !== null) {
            $query->whereBetween('end_date', [$fromExpireDate, $toExpireDate]);
        }
        $baseUrl = app()->environment('production') ? env('APP_URL') : url('/');
        $vouchers = $query->orderByDesc('created_at')
            ->paginate(10)
            ->withPath($baseUrl.'/admin/voucher/search')
            ->appends($request->input());

        $Users = User::all();
        return view('admin.voucher.index', compact('vouchers', 'Users'));
    }

    public function saveImage(request $request,$id){
        $filePath = $request->file('image')->getPathname();
        $ownerId =$id;
        $owner= 'voucher';
        $image = Image::where('voucher_id',$id)->get();
        try {
        if ($image->count() > 0) {
            //call update
            $image = $image->first();
            $imageRecord= $this->base64Service->updateById($filePath,$image->id);
        }else{
            //call create new
            $imageRecord = $this->base64Service->saveFileToDb($filePath,$owner,$ownerId);
        }

            return back()->with('success', 'Image updated successfully');
        }
        catch (\Exception $e) {
            return back()->with('error', 'Failed to update image: ' . $e->getMessage());
        }
    }

    //voucher id
    public function getImage($id){
        $image= Image::where('voucher_id',$id)->first();
        if($image->count() > 0){
            return response()->json([
                'success' => true,
                'data' => $image->img,
            ]);
        }else{
            return response()->json([
                'success' => false,
                'message' => 'Image not found'
            ],400);
        }
    }

}
