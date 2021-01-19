<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\UserActivity;
use App\Gender;
use Carbon\Carbon;
use PDF;

class AdminUserManagementController extends Controller
{
    // index page
    public function index (Request $request) {
        // get all users
        $users = User::orderBy('id', 'desc')->paginate(10);
        return view('v1.admin.authenticated.user.index', ['users' => $users]);
    }

    // diable/enable user
    public function changeUserStatus(Request $request, $id) {
        $id = \Crypt::decrypt($id);  // decrypt user id

        $user = User::where('id', $id);  // search for user
        // check if user record exit
        if($user->count() > 0 ) {
            // user record found - check if user is active
            if ($user->pluck('is_active')->first()) {
                // user is active - disable user
                $is_active = [
                    'is_active' => 0,
                ];

                $update_user_record = $user->update($is_active);  // update user record

                // check if record was updated
                if ($update_user_record) {
                    // user record updated - record activity and notify admin
                    UserActivity::create([
                        'user_id' => \Auth::user()->id,
                        'activity' => 'Disabled a user.'
                    ])->save();

                    $notification = [
                        'message' => 'User disabled successfully.',
                        'alert-type' => 'success',
                    ];

                    return redirect()
                            ->back()
                            ->with($notification);
                } else {
                    // user record update failed - notify admin
                    $notification = [
                        'message' => 'User disable operation failed.',
                        'alert-type' => 'error',
                    ];

                    return redirect()
                            ->back()
                            ->with($notification);
                }
            } else {
                // user is inactive - enable user
                $is_active = [
                    'is_active' => 1,
                ];

                $update_user_record = $user->update($is_active);  // update user record

                // check if user record was updated
                if ($update_user_record) {
                    // user record updated - record activity and notify admin
                    UserActivity::create([
                        'user_id' => \Auth::user()->id,
                        'activity' => 'Enabled a user.'
                    ])->save();

                    $notification = [
                        'message' => 'User enabled successfully.',
                        'alert-type' => 'success',
                    ];

                    return redirect()
                            ->back()
                            ->with($notification);
                } else {
                    // user record update failed - notify admin
                    $notification = [
                        'message' => 'User enable operation failed.',
                        'alert-type' => 'error',
                    ];

                    return redirect()
                            ->back()
                            ->with($notification);
                }
            }

        } else {
            // user record not found - notify admin
            $notification = [
                'message' => 'User record not found.',
                'alert-type' => 'warning',
            ];

            return redirect()
                    ->back()
                    ->with($notification);
        }

    }

    // search user
    public function searchUser(Request $request) {
        // validation
        $this->validate($request, [
            'search' => 'required|email',
        ]);
        
        // search for query
        $user = User::where('email', 'LIKE', '%'.$request->search.'%')->paginate();

        // check whether user exist
        if ($user->count() > 0) {
            // user exist - return record
            return view('v1.admin.authenticated.user.index', ['users' => $user]);
        } else {
            // user does exit - notify admin
            $notification = [
                'message' => 'User record not found.',
                'alert-type' => 'error',
            ];

            return redirect()
                    ->back()
                    ->with($notification);
        }
    }

    // view specific user record
    public function viewUser(Request $request, $id) {
        // decrypt user id
        $id = \Crypt::decrypt($id);

        // get user record
        $user = User::find($id);

        // get user activity
        $user_activity = UserActivity::where('user_id', $id)->orderBy('id', 'desc')->limit(6)->get();

        // check if user record exit
        if ($user->count() > 0) {
            // user record found.
            return view('v1.admin.authenticated.user.view', ['user' => $user, 'user_activities' => $user_activity]);
        } else {
            // user record not found - notify admin
            $notification = [
                'message' => 'User record not found.',
                'alert-type' => 'error',
            ];

            return redirect()
                    ->back()
                    ->with($notification);
        }
    }

    // get add user
    public function getAddUser(Request $request) {
        $gender = Gender::all()->where('is_active', 1);
        return view('v1.admin.authenticated.user.add', ['genders' => $gender]);
    }

    // post add user
    public function postAddUser(Request $request) {
        // validation
        $this->validate($request, [
            'full_name' => 'required|regex:/^[a-zA-Z\s]*$/',
            'email' => 'required|email',
            'dob' => 'required|date',
            'gender' => 'required|numeric',
            'country' => 'required|alpha',
            'state' => 'required|alpha',
            'address' => 'required|regex:/^[a-zA-Z\s\0-9]*$/',
            'password' => 'required|alpha-num',
            'role' => 'required|alpha',
        ]);

        // initialize user
        $user = new User();
        // add user information
        $user->full_name = strtolower($request->full_name);
        $user->email     = strtolower($request->email);
        $user->dob       = strtolower($request->dob);
        $user->gender_id = $request->gender;
        $user->country   = strtolower($request->country);
        $user->state     = strtolower($request->state);
        $user->address   = strtolower($request->address);
        $user->password  = \Hash::make($request->password);
        $user->is_active = 1;
        // check the assigned role
        if ($request->role == 'staff') {
            $user->is_staff = 1;
        } elseif($request->role == 'super') {
            $user->is_staff = 1;
            $user->is_super = 1;
        }

        // save user record
        $save_user = $user->save();

        // check if user record was saved successfully
        if ($save_user) {
            // record saved successfully -  notify admin
            $notification = [
                'message' => 'User record saved successfully.',
                'alert-type' => 'success',
            ];

            return redirect()
                    ->route('get-admin-user-mgnt')
                    ->with($notification);
        } else {
            // record not saved - notify admin
            $notification = [
                'message' => 'An error has occured, kindly try again.',
                'alert-type' => 'error',
            ];

            return redirect()
                    ->back()
                    ->with($notificationa);
        }
    }
}
