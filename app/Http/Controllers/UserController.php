<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function setting()
    {
        return view('user.setting');
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
