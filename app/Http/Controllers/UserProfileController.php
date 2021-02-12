<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\UserActivity;
use App\User;

class UserProfileController extends Controller
{
    // index / profile
    public function index (Request $request) {
         // get user activity
         $activity = UserActivity::where('user_id', \Auth::user()->id)->orderBy('id', 'desc')->limit(2)->get();

         // check if record was found
         if ($activity->count() > 0) {
             $activity =  $activity;
         } else {
             $activity = null;
         }
        // return view
        return view('v1.user.authenticated.profile.index', ['activity' => $activity]);
    }

    // get settings
    public function settings (Request $request) {
        // return view
        return view('v1.user.authenticated.profile.settings');
    }

    // post settings
    public function post_settings (Request $request) {
        // validation
        $this->validate($request, [
            'password' => 'required',
            'new_password' => 'required|regex:/^[a-zA-Z\0-9\@\s\.\_\*\#]*$/|min:6|confirmed',
            'new_password_confirmation' => 'required|regex:/^[a-zA-Z\0-9\@\s\.\_\*\#]*$/|min:6',
        ]);

        // compare db and request password
        if (\Hash::check($request->password, \Auth::user()->password)) {
            // password match - update user password - record activity
            $user = User::where('id', \Auth::user()->id);

            // check if user exist
            if ($user->count() > 0) {
                // user record exist - update password
                $change_password = [
                    'password' => \Hash::make($request->new_password),
                ];

                // update user record
                $user_update = $user->update($change_password);

                // check if record was update
                if ($user_update) {
                    // update successsful - record activity - notify user
                    app('App\Http\Controllers\Helper')->user_activity('changed password');

                    $notification = [
                        'message' => 'Password changed successfully.',
                        'alert-type' => 'success',
                    ];

                    return redirect()
                            ->back()
                            ->with($notification);
                    
                } else {
                    // update error occured - notify user
                    $notification = [
                        'message' => 'An error has occured, kindly try again.',
                        'alert-type' => 'error',
                    ];

                    return redirect()
                            ->back()
                            ->with($notification);
                }
            } else {
                // user record doesn't exit - log user out
                return redirect()
                        ->route('get-user-logout');
            }

        } else {
            // password don't match - notify user
            $notification = [
                'message' => 'Passwords do not match.',
                'alert-type' => 'warning',
            ];

            return redirect()
                    ->back()
                    ->with($notification);
        }
        
    }

    // delete user account
    public function delete_user_account (Request $request) {
        // get current user record

        // update record

        // log user out

        // notify admins of a deleted account
    }
}
