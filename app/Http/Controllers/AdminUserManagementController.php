<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use PDF;

class AdminUserManagementController extends Controller
{
    // index page
    public function index (Request $request) {
        // get all users
        $users = User::orderBy('id', 'desc')->paginate(2);
        return view('v1.admin.authenticated.user.index', ['users' => $users]);
    }

    // diable/enable user
    public function changeUserStatus(Request $request, $id) {
        $id = \Crypt::decrypt($id);  // decrypt user id

        $user = User::where('id', $id);  // search for user
        // check if user record exit
        if($user->count() >0 ) {
            // user record found - check if user is active
            if ($user->pluck('is_active')->first()) {
                // user is active - disable user
                $is_active = [
                    'is_active' => 0,
                ];

                $update_user_record = $user->update($is_active);  // update user record

                // check if record was updated
                if ($update_user_record) {
                    // user record updated - notify admin
                    $notification = [
                        'message' => 'User disabled successfully',
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
                    // user record updated - notify admin
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

    // add user
    public function getAddUser(Request $request) {
        return view('v1.admin.authenticated.user.add');
    }

    // generate and download all user record
    public function allUserPdfGenerator(Request $request) {
        // get all users
        $users = User::all();
    }
}
