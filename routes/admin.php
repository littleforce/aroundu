<?php
Route::group(['prefix' => 'admin', 'namespace' => 'Admin'], function (){
    Route::get('/login', 'LoginController@index')->name('login');
    Route::post('/login', 'LoginController@login');
    Route::get('/logout', 'LoginController@logout');

    Route::group(['middleware' => 'auth:admin'], function (){
        Route::get('/home', 'HomeController@index');

        Route::group(['middleware' => 'can:system'], function (){
            //管理人员页面
            Route::get('/users', 'UserController@index');
            Route::get('/users/create', 'UserController@create');
            Route::post('/users/store', 'UserController@store');
            Route::get('/users/{user}/role', 'UserController@role');
            Route::post('/users/{user}/role', 'UserController@storeRole');
            //角色
            Route::get('/roles', 'RoleController@index');
            Route::get('/roles/create', 'RoleController@create');
            Route::post('/roles/store', 'RoleController@store');
            Route::get('/roles/{role}/permission', 'RoleController@permission');
            Route::post('/roles/{role}/permission', 'RoleController@storePermission');
            //权限
            Route::get('/permissions', 'PermissionController@index');
            Route::get('/permissions/create', 'PermissionController@create');
            Route::post('/permissions/store', 'PermissionController@store');
        });

        Route::group(['middleware' => 'can:article'], function (){
            //审核模块
            Route::get('/articles', 'ArticleController@index');
            Route::post('/articles/{article}/status', 'ArticleController@status');
        });

        Route::group(['middleware' => 'can:topic'], function (){
            //专题模块
            Route::resource('topics', 'TopicController', ['only' => ['index', 'destroy']]);
        });

        Route::group(['middleware' => 'can:notice'], function (){
            //通知模块
            Route::resource('notices', 'NoticeController', ['only' => ['index', 'create', 'store']]);
        });
    });
});