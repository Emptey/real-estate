<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Helper;
use App\Mail\TwoFaVerification;
use Illuminate\Support\Facades\Mail;
use App\User;

class AdminLoginController extends Controller
{
    // login get request
    public function getLogin(Request $request) {
        return view('v1.admin.auth.login');
    }
    
    // login post request
    public function postLogin(Request $request) {
        // validation
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required|min:6'
        ]);

        // authentication
        if (\Auth::attempt(['email' => $request->email, 'password' => $request->password, 'is_active' => 1, 'is_staff' => 1])) {
                // generate tandom token
                $token = Helper::random_number();
                
                // get active user record
                $user = User::where('email', $request->email);

                // check if user exist
                if ($user->count() > 0) {
                    // user exist -  update record
                    $new_token = [
                        'remember_token' => $token
                    ];

                    $user->update($new_token);  // update user record

                    if ($user) {
                        // record updated - send mail
                        $details = [
                            'title' => '2FA VERIFICATION',
                            'body' => 'A login attempt was made on your account, if this was you, kindly use the token below to log in.',
                            'token' => $token,
                        ];
        
                        // send 2fa mail
                        Mail::to($request->email)->send(new TwoFaVerification($details));
        
                        // check if mail was sent
                        if (!Mail::failures()) { 
                            // 2fa mail sent
                            $notification = [
                                'message' => 'A verification token has been sent to your email, kindly check.',
                                'alert-type' => 'success',
                            ];

                            return redirect()
                                    ->route('get-admin-2fa')
                                    ->with($notification);
                        } else {
                            // 2fa mail sending failed
                            $notification = [
                                'message' => 'Login request failed, please try again.',
                                'alert-type' => 'error',
                            ];

                            return redirect()
                                    ->back();
                        }
                    }

                } else {
                    // user doesn't exit
                }
                // return redirect()
                //         ->route('get-dashboard');
        } else {
            // authentication failed
            $notification = [
                'message' => 'Invalid credentials supplied.',
                'alert-type' => 'error',
            ];

            return redirect()
                    ->back()
                    ->with($notification);

        }

    }

    // get 2fa page
    public function get_two_fa(Request $request) {
        if (\Auth::check()) {
            // user is credential authenticated
            return view('v1.admin.auth.two_fa');
        }
        // user isn't credential authenticated
        return redirect()
                ->back();
    }

    // post 2fa 
    public function post_two_fa(Request $request) {
        // validation
        $this->validate($request, [
            'login_token' => 'numeric|required',
        ]);

        // get user
        $user = User::where('email', \Auth::user()->email)
                        ->where('remember_token', $request->login_token);

        // check if record exist
        if ($user) {
            // record exist - db record
            $del_token = [
                'remember_token' => null
            ];

            $update_user = $user->update($del_token);

            // check if update was successful
            if ($update_user) {
                // update successful - set user 2fa authenticated
                $request->session()->put('two_fa', 1);

                return redirect()
                        ->route('get-dashboard');
            } else {
                // update failed
                $notification = [
                    'message' => 'An error has occured, kindly try again later.',
                    'alert-type' => 'error',
                ];

                return redirect()
                        ->back()
                        ->with($notification);
            }
            
        } else {
            // record doesn't exist
        }
    }

    // logout
    public function logout() {
        \Auth::logout();  // destroying session
        return redirect()
                ->route('admin-login');
    }
}
    
