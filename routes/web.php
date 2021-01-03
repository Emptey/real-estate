<?php

use Illuminate\Support\Facades\Route;

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

// admin auth group 
Route::group(['prefix' => 'authenticator'], function(){
    // admin get login
    Route::get('/', [
        'as' => 'admin-login',
        'uses' => 'AdminLoginController@getLogin',
    ]);

    // admin post login
    Route::post('/', [
        'as' => 'post-admin-login',
        'uses' => 'AdminLoginController@postLogin',
    ]);

    // admin authorization routes
    Route::group(['prefix' => 'authorized', 'middleware' => 'admin_auth'], function() {
        Route::get('/', [
            'as' => 'get-dashboard',
            'uses' => 'AdminDashboardController@index',
        ]);

        Route::get('logout', [
            'as' => 'admin-logout',
            'uses' => 'AdminLoginController@logout',
        ]);
    });
});
// end admin auth group //
