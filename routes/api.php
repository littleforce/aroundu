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

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});
//
//Route::group(['middleware' => 'auth:api', 'namespace' => 'Api'], function () {
//    Route::post('posts/{posts}/publish', 'PostController@publish');//test api
//
//
//
//
//    // todo
//});
//
//Route::group(['namespace' => 'Api'], function () {
//    Route::post('login', 'LoginController@login');
//    Route::post('register', 'RegisterController@register');
//
//    Route::get('user/{user}', 'UserController@show');
//    Route::get('user/{user}/articles', 'UserController@articles');
//    Route::get('user/{user}/followers', 'UserController@followers');
//    Route::get('user/{user}/following', 'UserController@following');
//
//    Route::get('articles', 'ArticleController@index');
//    Route::get('article/{id}', 'ArticleController@show');
//});

$api = app('Dingo\Api\Routing\Router');
$api->version('v1',function ($api){
    $api->group(['namespace' => 'App\Http\Controllers\Api\V1'], function($api){
        $api->post('login', 'AuthenticateController@authenticate');//登录
        $api->post('register', 'AuthenticateController@register');//注册

        $api->group(['middleware'=>'api.auth'], function ($api){
            $api->get('user/me', 'AuthenticateController@AuthenticatedUser');//获取当前用户信息
            $api->post('user/me', 'UserController@update');//编辑用户信息
            $api->get('user/{id}/follow', 'UserController@follow');//关注用户
            $api->get('user/{id}/unfollow', 'UserController@unfollow');//取消关注用户

            $api->get('/article/{id}/vote', 'ArticleController@vote');//赞文章
            $api->get('/article/{id}/unvote', 'ArticleController@unvote');//取消赞文章
            $api->post('/article', 'ArticleController@store');//创建文章
            $api->put('/article/{id}', 'ArticleController@update');
            $api->delete('/article/{id}', 'ArticleController@destroy');//删除文章
            $api->post('/article/{id}/comment', 'ArticleController@comment');//创建评论

            $api->get('/comment/{id}/vote', 'CommentController@vote');//赞评论
            $api->get('/comment/{id}/unvote', 'CommentController@unvote');//取消赞评论
            $api->delete('/comment/{id}', 'CommentController@destroy');//删除评论
        });

        $api->get('user/{id}','UserController@show');//用户信息
        $api->get('user/{id}/articles','UserController@articles');//返回用户文章
        $api->get('user/{id}/followers', 'UserController@followers');//返回用户粉丝
        $api->get('user/{id}/following', 'UserController@following');//用户关注
        $api->get('user/{id}/comments', 'UserController@comments');//用户评论

        $api->get('articles', 'ArticleController@index');//文章列表
        $api->get('article/{id}', 'ArticleController@show');//文章详情
        $api->get('article/{id}/comments', 'ArticleController@comments');//文章评论
    });
});
