<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Image;

class UserController extends Controller
{
    public function setting()
    {
        return view('user.setting')->withUser(\Auth::user());
    }

    public function uploadAvatar(Request $request)
    {
        $file = $request->file('file');
        $dir = '/images/'.date('Y').'/'.date('m').'/'.date('d');
        if (!Storage::exists($dir)) {
            Storage::makeDirectory($dir);
        }
        $path = md5(time()).'.'.$file->getClientOriginalExtension();
        Storage::putFileAs($dir, $file, $path);
        $user = User::find(\Auth::id());
        $user->avatar = 'http://localhost/storage'.$dir.'/'.$path;
        $user->save();
        dd($user);
        return '/storage'.$dir.'/'.$path;
    }

    public function settingStore()
    {

    }

    public function show($id)
    {
        $user = User::find($id);
        return view('user.show', compact('user'));
    }

    public function follow($id)
    {
        $user = \Auth::user();
        $user->followThisUser($id);
        return back();
    }

    public function unfollow($id)
    {
        $user = \Auth::user();
        $user->unfollowThisUser($id);
        return back();
    }
}
