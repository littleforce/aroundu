<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\RegisterRequest;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RegisterController extends Controller
{
    public function register(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:users,name|min:3|max:255',
            'email' => 'required|unique:users,email|email',
            'password' => 'required|min:6',
        ]);
        $name = $request['name'];
        $email = $request['email'];
        $password = bcrypt($request['password']);
        $user = User::create(compact('name', 'email', 'password'));
        return [
            'error' => 0,
            'msg' => '注册成功',
        ];
    }
}
