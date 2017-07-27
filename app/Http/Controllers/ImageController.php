<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Image;

class ImageController extends Controller
{
    public function imageUpload(Request $request)
    {
        $file = $request->file('file');
        $dir = '/images/'.date('Y').'/'.date('m').'/'.date('d');
        if (!Storage::exists($dir)) {
            Storage::makeDirectory($dir);
        }
        $path = md5(time()).'.'.$file->getClientOriginalExtension();
//        $mime = Image::make($file)->mime();
//        $extension = substr(strrchr($mime, "/"), 1);
//        $path = md5(time()).'.'.$extension;
//        Image::make($file)->resize(300, 200)->save($path);
        Storage::putFileAs($dir, $file, $path);
        return '/storage'.$dir.'/'.$path;
    }
}
