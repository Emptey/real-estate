<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\UserActivity;
use App\User;

class AdminSettingsController extends Controller
{
    // index page
    public function index (Request $request) {
        // get all 8 recent user activities
        $my_activity = UserActivity::where('user_id', \Auth::user()->id)
                        ->orderBy('id', 'desc')->limit(8)->get();

        // return index page
        return view('v1.admin.authenticated.settings.index', ['activities' => $my_activity]);
    }

    // change password
    public function change_password(Request $request) {
        // validation
        $this->validate($request, [
            'password' => 'required',
            'new_password' => 'required|regex:/^[a-zA-Z\0-9\@\s\.\_\*\#]*$/|confirmed|min:6',
            'new_password_confirmation' => 'required|regex:/^[a-zA-Z\0-9\@\s\.\_\*\#]*$/|min:6',
        ]);

        // check if current psswrd matches db psswrd
        if (\Hash::check($request->password, \Auth::user()->password)) {
            // password match - get user record
            $user = User::where('id', \Auth::user()->id);

            // change password
            $new_password = [
                'password' => \Hash::make($request->new_password),
            ];

            // update user record
            $update_record = $user->update($new_password);

            // check if password was updated
            if ($update_record) {
                // record updated - notify admin
                $notification = [
                    'message' => 'Passsword changed successfully.',
                    'alert-type' => 'success',
                ];

                return redirect()
                        ->back()
                        ->with($notification);

            } else {
                // record failed to update - notify admin
                $notification = [
                    'mesaage' => 'An error has occured. Kindly try again.',
                    'alert-type' => 'danger',
                ];

                return redirect()
                        ->back()
                        ->with($notification);
            }
        } else {
            // password don't match -  notify admin
            $notification = [
                'message' => 'Passwords don\'t match.',
                'alert-type' => 'warning',
            ];

            return redirect()
                    ->back()
                    ->with($notification);
        }
    }

}
