<?php

namespace App\Http\Controllers\Boss;

use App\Http\Controllers\Controller;
use App\Models\Image;
use App\Models\Yard;
use App\Services\Base64FileServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class YardImageController extends Controller
{
    public function __construct(Base64FileServiceProvider $base64Service)
    {
        $this->base64Service = $base64Service;
    }

    public function index(){
        $yardList=Auth::guard('boss')->user()->Yards()->where('block',false)->get();
        return view('boss.yard_image.index')->with('yardList',$yardList);
    }

    //yard id
    public function save(request $request,$id){
        $filePath = $request->file('image')->getPathname();
        $ownerId =$id;
        $owner= 'yard';
        try {
            $this->base64Service->saveFileToDb($filePath,$owner,$ownerId);
            return back()->with('success', 'Image added successfully');
        }
        catch (\Exception $e) {
            return back()->with('error', 'Failed to add image: ' . $e->getMessage());
        }
    }

    //image id
    public function update(request $request,$id){
        try {
            $filePath = $request->file('image')->getPathname();
            $this->base64Service->updateById($filePath,$id);
            return back()->with('success', 'Image updated successfully');
        }catch (\Exception $e) {
            return back()->with('error', 'Failed to update image: ' . $e->getMessage());
        }
    }

    //image id
    public function delete($id){
        $image= Image::find($id);
        $image->delete();
        return back()->with('success', 'Image deleted successfully');
    }
}
