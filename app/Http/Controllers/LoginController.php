<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }

    public function login(LoginRequest $request)
    {
        //dd($request->all());
        $email = $request['email'];
        $password = $request['password'];
        $user = compact('email', 'password');
        $remember = $request['remember'];
        //dd($is_remember);
        if (\Auth::attempt($user, $remember)) {
            return redirect('/article');
        }
        return \Redirect::back()->withErrors('邮箱密码不匹配');

    }

    public function logout()
    {
        \Auth::logout();
        return redirect('/login');
    }
}
