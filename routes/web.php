<?php

use Illuminate\Support\Facades\Route;
use Carbon\Carbon;
use App\User;

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

    // admin get 2fa
    Route::get('/2fa-verification', [
        'as' => 'get-admin-2fa',
        'uses' => 'AdminLoginController@get_two_fa',
    ]);

    // admin post 2fa
    Route::post('/2fa-verification', [
        'as' => 'post-admin-2fa',
        'uses' => 'AdminLoginController@post_two_fa',
    ]);

    // admin authorization routes
    Route::group(['prefix' => 'authorized', 'middleware' => 'admin_auth'], function() {
        // admin dashboard route
        Route::get('/', [
            'as' => 'get-dashboard',
            'uses' => 'AdminDashboardController@index',
        ]);

        /* user management routes */
        Route::get('/user', [
            'as' => 'get-admin-user-mgnt',
            'uses' => 'AdminUserManagementController@index',
        ]);

        // search user
        Route::post('/user', [
            'as' => 'search-user',
            'uses' => 'AdminUserManagementController@searchUser',
        ]);

        // generate all user pdf report
        Route::get('/user/generate/pdf', function() {
            $user = User::all();
            $pdf = PDF::loadView('v1.admin.pdfs.all_users_record', ['users' => $user]);
            App\UserActivity::create([
                'user_id' => \Auth::user()->id,
                'activity' => 'Downloaded users report.'
            ])->save();

            return $pdf->download('all_user_report_'.Carbon::now().'.pdf');
        });

        // view specific record
        Route::get('/user/view/{id}', [
            'as' => 'view-user',
            'uses' => 'AdminUserManagementController@viewUser',
        ]);

        // add user
        Route::get('/user/add', [
            'as' => 'add-user',
            'uses' => 'AdminUserManagementController@getAddUser',
        ])->middleware('adduser');

        // disable/enable user
        Route::get('/user/status/{id}', [
            'as' => 'change-user-status',
            'uses' => 'AdminUserManagementController@changeUserStatus'
        ]);
        /* end user management routes */

        // logout route
        Route::get('logout', [
            'as' => 'admin-logout',
            'uses' => 'AdminLoginController@logout',
        ]);
    });
});
// end admin auth group //
