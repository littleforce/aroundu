<?php

namespace App\Http\Controllers\Api;

use App\Article;
use App\Http\Requests\LoginRequest;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LoginController extends Controller
{
    public function login(LoginRequest $request)
    {
        $email = $request['email'];
        $password = $request['password'];
        $user = compact('email', 'password');
        if (\Auth::attempt($user)) {
            $client = \DB::table('oauth_clients')->where('password_client', 1)->first();
            Request()->request->add([
                'grant_type' => 'password',
                'username' => $email,
                'password' => $password,
                'client_id' => $client->id,
                'client_secret' => $client->secret,
                'scope' => '*'
            ]);

            $proxy = Request::create(
                'oauth/token',
                'POST'
            );

            $response = \Route::dispatch($proxy);//object
            $response_content = json_decode($response->getContent(), true);
            $array['error'] = 0;
            $array['msg'] = 'success!';
            $array['token_type'] = $response_content['token_type'];
            $array['expires_in'] = $response_content['expires_in'];
            $array['access_token'] = $response_content['access_token'];
            $array['refresh_token'] = $response_content['refresh_token'];

            return $array;
        } else {
            return [
                'error' => 1,
                'msg' => '邮箱密码不匹配',
            ];
        }
    }
}
