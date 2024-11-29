<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\District;
use App\Models\Image;
use App\Models\Province;
use App\Models\User;
use App\Services\Base64FileServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    public function __construct(Base64FileServiceProvider $base64Service)
    {
        $this->base64Service = $base64Service;
    }
    public function index()
    {
        $user = Auth::user();

        $provinces = Province::all();
        $districts = District::where('province_id', $user->province_id)->get();
        return view('user.profile.index', compact('user', 'provinces', 'districts'));
    }

    // Update user profile
    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        // Validate input data
        $request->validate([
            'full_name' => 'required|string|max:255',
            'phone' => 'required|string|max:15',
            'province' => 'required|integer',
            'district' => 'required|integer',
            'address' => 'required|string|max:255',
        ], [
            'full_name.required' => 'Please enter your full name.',
            'phone.required' => 'Please enter your phone number.',
            'address.required' => 'Please enter your address.',
            'province.required' => 'Please select a province.',
            'district.required' => 'Please select a district.',
        ]);

        try {
            // Update user profile information
            $user->update([
                'full_name' => $request->full_name,
                'phone' => $request->phone,
                'district_id' => $request->district,
                'address' => $request->address,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Profile updated successfully.',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ]);
        }
    }
    public function getProvinces()
    {
        $provinces = Province::all();
        return response()->json($provinces);
    }
    public function getDistricts(Request $request)
    {
        if (!$request->has('province_id')) {
            return response()->json(['error' => 'Province ID is required'], 400);
        }

        $districts = District::where('province_id', $request->province_id)->get();

        if ($districts->isEmpty()) {
            return response()->json(['error' => 'No districts found for this province'], 404);
        }

        return response()->json($districts);
    }

    public function detail(Request $request, $id)
    {
        $response = User::findOrFail($id);
        $district = District::findOrFail($response->district_id);
        if ($response) {
            return response()->json([
                'success'   => true,
                'data'      => $response,
                'district' => $district,
                'province' => $district->province,
            ]);
        }

        return response()->json([
            'success'   => false,
            'message'   => 'Saving failed.',
        ]);
    }

    // Change user password
    public function updatePassword(Request $request)
    {
        try {
            $validated = Validator::make($request->all(),[
            'current_password' => 'required',
            'new_password' => 'required|confirmed|min:8',
        ]);
            if ($validated->fails()) {
                if ($request->ajax()) {
                    return response()->json([
                        'success' => false,
                        'errors' => $validated->errors()
                    ], 422);
                }
                return redirect()->back()->withErrors($validated)->withInput();
            }

            // Check current password, update password if valid
            if (Hash::check($request->current_password, auth()->user()->password)) {
                auth()->user()->update([
                    'password' => bcrypt($request->new_password),
                ]);

                return response()->json([
                    'success' => true,
                    'message' => 'Password updated successfully.',
                ]);
            }else
            {
                return response()->json([
                    'success' => false,
                    'errors' => ['current_password' => ['Current password is incorrect.']],
                ],422
                );
            }
        }catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ]);
        }
    }

    public function imageUpload(Request $request){
        $filePath = $request->file('image')->getPathname();
        $ownerId =Auth::guard('web')->user()->id;
        $owner= 'user';
        try {
            $images= Image::where('user_id',$ownerId)->get();
            if ($images->count() == 0) {
                // chuưa có hình thì tạo mới
                $this->base64Service->saveFileToDb($filePath,$owner,$ownerId);
            }else{
                // có hình thì cập nhật
                $this->base64Service->updateById($filePath,$images->first()->id);
            }
            return back()->with('success','Your Avatar uploaded successfully.');
        }
        catch (\Exception $e) {
            return back()->with('error', 'Failed to update image: ' . $e->getMessage());
        }
    }
}
