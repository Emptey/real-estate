<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\UserActivity;
use App\User;
use App\UserBank;

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

    // get edit profile
    public function edit_profile (Request $request) {
        // return view
        return view('v1.user.authenticated.profile.edit');
    }

    // post edit profile personal
    public function post_edit_profile_personal (Request $request) {
        // validation
        $this->validate($request, [
            'email' => 'required|email',
            'phone' => 'required|numeric',
        ]);

        // get user record
        $user = User::where('id', \Auth::user()->id);

        // check if record exist
        if ($user->count() > 0) {
            // record exit - update record
            $new_info = [
                'email' => $request->email,
                'phone' => $request->phone,
            ];

            // update record
            $update_user = $user->update($new_info);

            // check if record was updated
            if ($update_user) {
                // record updated notify user
                $notification = [
                    'message' => 'Personal infomation updated successfully.',
                    'alert-type' => 'success',
                ];

                // record activity
                $activity = 'Updated personal info.';
                app('App\Http\Controllers\Helper')->user_activity($activity);

                return redirect()
                        ->route('get-user-profile')
                        ->with($notification);
            } else {
                // an error has occured - notify user
                $notification = [
                    'message' => 'An error has occured, kindly try again.',
                    'alert-type' => 'error',
                ];

                return redirect()
                        ->back()
                        ->with($notification);
            }
           
        } else {
            // record doesn't exit -  log user out -  notify admin of unauthorized trying to change user detail
            return redirect()
                    ->route('get-user-logout');

        }
    }

    // post edit profile bank
    public function post_edit_profile_bank (Request $request) {
        // validation
        $this->validate($request, [
            'account_name' => 'required|regex:/^[a-zA-Z\s]*$/',
            'account_number' => 'required|numeric',
            'bank' => 'required|regex:/^[a-zA-Z\s\,]*$/',
        ]);

        // get user record
        $get_user_bank = UserBank::where('user_id', \Auth::user()->id);
        
        // cehck if user bank record exit
        if ($get_user_bank->count() > 0) {
            //  user bank record exist - update record
            $new_record = [
                'account_name' => strtolower($request->account_name),
                'account_number' => $request->account_number,
                'bank' => strtolower($request->bank),
            ];

            // update record
            $update_user_bank = $get_user_bank->update($new_record);

            // check if update was successfully
            if ($update_user_bank) {
                // update successful - notify user - redirect user
                $notification = [
                    'message' => 'Bank details updated successfully.',
                    'alert-type' => 'success',
                ];

                // record activity
                $activity = 'Updated bank details.';
                app('App\Http\Controllers\Helper')->user_activity($activity);

                return redirect()
                        ->route('get-user-profile')
                        ->with($notification);
            } else {
                // update failed - notify user
                $notification = [
                    'message' => 'An error has occured, kindly try again.',
                    'alert-type' => 'error',
                ];

                return redirect()
                        ->back()
                        ->with($notification);

            }
        } else {
            // user bak record doesn't exit - add new bank record
            $user_bank = new UserBank();

            // add user bank records
            $user_bank->user_id = \Auth::user()->id;
            $user_bank->account_name = strtolower($request->account_name);
            $user_bank->account_number = $request->account_number;
            $user_bank->bank = strtolower($request->bank);

            // save record
            $save_user_bank = $user_bank->save();

            // check if record was saved
            if ($save_user_bank) {
                // record saved successfully - notify user - record activity - redirect user
                $notification = [
                    'message' => 'Bank details saved successfully.',
                    'alert-type' => 'success',
                ];

                // record activity
                $activity = 'Added bank details.';
                app('App\Http\Controllers\Helper')->user_activity($activity);

                return redirect()
                        ->route('get-user-profile')
                        ->with($notification);
            } else {
                // record not saved, error occured - notify user
                $notification = [
                    'message' => 'An error has occured, kindly try again.',
                    'alert-type' => 'error',
                ];

                return redirect()
                        ->back()
                        ->with($notification);

            }
        }

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
                    app('App\Http\Controllers\Helper')->user_activity('Changed password');

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
