<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/register', 'RegisterController@index');
Route::post('/register', 'RegisterController@register');
Route::get('/login', 'LoginController@index');
Route::post('/login', 'LoginController@login');
Route::post('/logout', 'LoginController@logout');

Route::get('/user/me/setting', 'UserController@setting');
Route::post('/user/me/setting', 'UserController@settingStore');

Route::post('/comment/store', 'ArticleController@comment');
Route::get('/comment/{id}/vote', 'CommentController@vote');
Route::get('/comment/{id}/unvote', 'CommentController@unvote');


Route::get('/home', 'HomeController@index')->name('home');

Route::resource('article', 'ArticleController');
Route::post('article/summerImageUpload', 'ArticleController@summerImageUpload');