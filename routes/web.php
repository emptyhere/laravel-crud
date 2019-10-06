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

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home')->middleware('isActive');
//Route::get('/sendemail/{id}', 'UserController@sendEmail');

    Route::prefix('admin')->middleware('isActive')->group(function () {

            Route::get('post/all', 'PostController@indexAll')->name('allPosts');
            Route::get('user/all', 'UserController@indexAll')->name('allUsers');
            Route::get('superuser/all', 'AdminController@indexAll')->name('allAdmins');
            Route::get('post/delimg/{id}', 'PostController@destroyImg')->name('destroyImg');
            Route::resource('post', 'PostController', 
            ['names' => [
                'index' => 'admin.post.index',
                'store' => 'admin.post.store',
                'update' => 'admin.post.update',
                'edit' => 'admin.post.edit',
                'show' => 'admin.post.show',
                'destroy' => 'admin.post.delete',
            ]]);
            Route::resource('user', 'UserController', 
            ['names' => [
                'index' => 'admin.user.index',
                'store' => 'admin.user.store',
                'update' => 'admin.user.update',
                'edit' => 'admin.user.edit',
                'show' => 'admin.user.show',
                'destroy' => 'admin.user.delete',
            ]]);
            Route::resource('superuser', 'AdminController', 
            ['names' => [
                'index' => 'admin.superuser.index',
                'store' => 'admin.superuser.store',
                'update' => 'admin.superuser.update',
                'edit' => 'admin.superuser.edit',
                'show' => 'admin.superuser.show',
                'destroy' => 'admin.superuser.delete',
            ]]);
    });


    Route::prefix('cp')->middleware('isActive')->group(function () {
        Route::get('post/all', 'CpController@indexAll')->name('allCpPosts');
        Route::get('post/like/{id}', 'CpController@like')->name('cpLike');

        Route::resource('post', 'CpController', 
        ['names' => [
            'show' => 'cp.post.show',
            'destroy' => 'cp.post.delete',
        ]]);
    });
