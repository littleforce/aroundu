<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\User;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    public function index()
    {
        return view('auth.register');
    }

    public function register(RegisterRequest $request)
    {
        //dd(request(['name', 'email']));
        $name = $request['name'];
        $email = $request['email'];
        $password = bcrypt($request['password']);

        $user = User::create(compact('name', 'email', 'password'));
        return redirect('/login');
    }
}
