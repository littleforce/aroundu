<?php

namespace App\Http\Controllers\Api;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    public function show(User $user)
    {
        //dd($user);
        $array = $user->getAttributes();
        $array['article_count'] = $user->articles->count();
        $array['follower_count'] = $user->followers->count();
        $array['following_count'] = $user->following->count();
        $array['error'] = 0;
        $array['msg'] = '获取用户id为'.$user->id.'的信息';

        unset($array['password']);
        return $array;
    }

    public function articles(User $user)
    {
        $articles = $user->apiGetArticles();
        return $articles;
    }

    public function followers()
    {
        return [];
    }

    public function following()
    {
        return [];
    }
}
