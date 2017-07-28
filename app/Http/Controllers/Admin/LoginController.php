<?php

namespace App\Http\Controllers\Admin;

use GuzzleHttp\Client;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function index()
    {
        return view('admin.login.index');
    }

    public function login()
    {
        $this->validate(request(), [
            'name' => 'required|min:2',
            'password' => 'required|min:5',
        ]);
        $user = request(['name','password']);
        if (\Auth::guard('admin')->attempt($user)) {
            return redirect('/admin/home');
        }
        return \Redirect::back()->withErrors('用户名密码不匹配');
    }

    public function logout()
    {
        \Auth::guard('admin')->logout();
        return redirect('/admin/login');
    }
}
