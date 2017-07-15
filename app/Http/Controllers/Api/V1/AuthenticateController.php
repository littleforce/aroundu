<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\RegisterRequest;
use App\Transformers\UserTransformer;
use App\User;
use Illuminate\Http\Request;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;

class AuthenticateController extends ApiController
{
    public function authenticate(Request $request)
    {
        // grab credentials from the request
        $credentials = $request->only('email', 'password');

        try {
            // attempt to verify the credentials and create a token for the user
            if (! $token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'invalid_credentials'], 401);
            }
        } catch (JWTException $e) {
            // something went wrong whilst attempting to encode the token
            return response()->json(['error' => 'could_not_create_token'], 500);
        }

        // all good so return the token
        return response()->json(compact('token'));
    }

    public function register(Request $request)
    {
        $newUser = [
            'email' => $request->get('email'),
            'name' => $request->get('name'),
            'password' => $request->get('password'),
            'password_confirmation' =>$request->get('password_confirmation'),
        ];
        $rules = [
            'name' => 'required|min:3|max:10|unique:users,name',
            'email' => 'required|unique:users,email|email',
            'password' => 'required|min:6|max:16|confirmed',
        ];
        $validator = \Validator::make($newUser, $rules);
        if ($validator->fails()) {
            throw new \Dingo\Api\Exception\StoreResourceFailedException('Could not create new user.', $validator->errors());
        }
        $newUser['password'] = bcrypt($request->get('password'));
        $user = User::create($newUser);
//        $token = JWTAuth::fromUser($user);
//        return $token;
        return response()->json(['error' => 0, 'message' => '注册成功']);
    }

    /****
     * 获取用户的信息
     * @return \Illuminate\Http\JsonResponse
     */
    public function AuthenticatedUser()
    {
        try {
            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['user_not_found'], 404);
            }
        } catch (TokenExpiredException $e) {
            return response()->json(['token_expired'], $e->getStatusCode());
        } catch (TokenInvalidException $e) {
            return response()->json(['token_invalid'], $e->getStatusCode());
        } catch (JWTException $e) {
            return response()->json(['token_absent'], $e->getStatusCode());
        }
        // the token is valid and we have found the user via the sub claim
        return $this->response->array($user, new UserTransformer);
    }
}
