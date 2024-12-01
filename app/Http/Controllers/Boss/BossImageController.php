<?php

namespace App\Http\Controllers\Boss;

use App\Http\Controllers\Controller;
use App\Models\Image;
use App\Services\Base64FileServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BossImageController extends Controller
{
    public function __construct(Base64FileServiceProvider $base64Service)
    {
        $this->base64Service = $base64Service;
    }

    function index(){
        $currentBoss=Auth::guard('boss')->user();
        $images= Image::where('boss_id',$currentBoss->id)->get();
        return view('boss.image.index')->with('images',$images);
    }
    public function saveImage(request $request){
        $filePath = $request->file('image')->getPathname();
        $ownerId =Auth::guard('boss')->user()->id;
        $owner= 'boss';
        $images= Image::where('boss_id',$ownerId)->get();

        if ($images->count()>=20) {
            return back()->with('error','Images limit exceeded');
        }
        try {
            $this->base64Service->saveFileToDb($filePath,$owner,$ownerId);
            return back()->with('success', 'Image added successfully');
        }
        catch (\Exception $e) {
            return back()->with('error', 'Failed to update image: ' . $e->getMessage());
        }
    }

    public function updateImage(request $request,$id)
    {
        try {
            $filePath = $request->file('image')->getPathname();
            $this->base64Service->updateById($filePath,$id);
            return back()->with('success', 'Image updated successfully');
        }catch (\Exception $e) {
            return back()->with('error', 'Failed to update image: ' . $e->getMessage());
        }
    }
    public function deleteImage($id){
        $image= Image::find($id);
        $image->delete();
        return back()->with('success', 'Image deleted successfully');
    }

}
