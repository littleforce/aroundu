<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PostController extends Controller
{
    public function publish($post)
    {
        return [
            'post' => $post,
            'msg' => 'from api',
        ];
    }
}
