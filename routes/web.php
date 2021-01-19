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

        Route::post('/user/add', [
            'as' => 'post-add-user',
            'uses' => 'AdminUserManagementController@postAddUser',
        ])->middleware('adduser');

        // disable/enable user
        Route::get('/user/status/{id}', [
            'as' => 'change-user-status',
            'uses' => 'AdminUserManagementController@changeUserStatus'
        ]);
        /* end user management routes */

        /**property lisitng management */
        Route::group(['prefix' => 'property-listing'], function(){
            // get index page
            Route::get('/', [
                'as' => 'get-property-listing',
                'uses' => 'PropertyListingController@index',
            ]);

            // search property
            Route::post('/', [
                'as' => 'search-property',
                'uses' => 'PropertyListingController@searchProperty'
            ]);

            // change property status
            Route::get('change/status/{id}', [
                'as' => 'change-property-status',
                'uses' => 'PropertyListingController@changeStatus',
            ]);

            // view specific property
            Route::get('view/property/{id}', [
                'as' => 'view-property',
                'uses' =>'PropertyListingController@viewProperty',
            ]);

            // get add property page 1
            Route::get('add/{id?}', [
                'as' => 'get-add-property',
                'uses' => 'PropertyListingController@add_property',
            ]);

            // post add property - first set of details
            Route::post('add/property/', [
                'as' => 'post-add-property-first',
                'uses' => 'PropertyListingController@set_first_details',
            ]);

            // get add property page 2
            Route::get('add/property/step/2/{id?}', [
                'as' => 'get-step-two-property',
                'uses' => 'PropertyListingController@set_second_details',
            ]);

            // post add property - second set of details
            Route::post('add/property/step/2/', [
                'as' => 'post-add-property-second',
                'uses' => 'PropertyListingController@post_second_details',
            ]);

            // get add property page 3
            Route::get('add/property/step/3/{id?}', [
                'as' => 'get-step-three-property',
                'uses' => 'PropertyListingController@set_third_details',
            ]);

            // post add property page 3
            Route::post('add/property/step/3/', [
                'as' => 'post-add-property-third',
                'uses' => 'PropertyListingController@post_third_details',
            ]);

            // get update property page 1
            Route::get('update/property/{id}', [
                'as' => 'get-update-property-setp-one',
                'uses' => 'PropertyListingController@update_property_step_one',
            ]);

            // post update property page 1
            Route::post('update/property/', [
                'as' => 'post-update-property-step-one',
                'uses' => 'PropertyListingController@post_update_property_step_one',
            ]);

            // get update property page 2
            Route::get('update/property/step-2/{id}', [
                'as' => 'get-update-property-step-two',
                'uses' => 'PropertyListingController@get_update_property_step_two',
            ]);

            // post update property page 2
            Route::post('update/property/step-2/', [
                'as' => 'post-update-property-step-two',
                'uses' => 'PropertyListingController@post_update_property_step_two',
            ]);

            // get update property page 3
            Route::get('update/property/step-3/{id}', [
                'as' => 'get-update-property-step-three',
                'uses' => 'PropertyListingController@get_update_property_step_three',
            ]);

            // post update property page 3
            Route::post('update/property/step-3/', [
                'as' => 'post-update-property-step-three',
                'uses' => 'PropertyListingController@post_update_property_step_three',
            ]);

        });
        /** end property listing management */

        // investment route group/list
        Route::group(['prefix' => 'investment'], function(){
            // index page
            Route::get('/', [
                'as' => 'get-admin-investment',
                'uses' => 'AdminInvestmentController@index',
            ]);

            // search investment
            Route::post('/', [
                'as' => 'search-investment',
                'uses' => 'AdminInvestmentController@search_investment',
            ]);

            // change investment feature
            Route::get('change/rentage/status/{id}', [
                'as' => 'change-investment-rentage-status',
                'uses' => 'AdminInvestmentController@change_rentage_status',
            ]);
        });
        // end investment group

        // logout route
        Route::get('logout', [
            'as' => 'admin-logout',
            'uses' => 'AdminLoginController@logout',
        ]);
    });
});
// end admin auth group //
