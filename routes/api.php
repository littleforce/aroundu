<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['middleware' => 'auth:api', 'namespace' => 'Api'], function () {
    Route::post('posts/{posts}/publish', 'PostController@publish');//test api




    // todo
});

Route::group(['namespace' => 'Api'], function () {
    Route::post('login', 'LoginController@login');
    Route::post('register', 'RegisterController@register');

    Route::get('user/{user}', 'UserController@show');
    Route::get('user/{user}/articles', 'UserController@articles');
    Route::get('user/{user}/followers', 'UserController@followers');
    Route::get('user/{user}/following', 'UserController@following');

    Route::get('articles', 'ArticleController@index');
    Route::get('article/{id}', 'ArticleController@show');
});
