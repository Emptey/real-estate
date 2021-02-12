<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Helper;
use App\Mail\TwoFaVerification;
use Illuminate\Support\Facades\Mail;
use App\User;
use App\Gender;
use App\Notification;

class UserDefaultPagesController extends Controller
{
    // get index
    public function index (Request $request) {
        return view('v1.welcome');
    }

    // get login
    public function login (Request $request) {
        // return view
        return view('v1.user.auth.login');
    }

    // post login page
    public function postLogin (Request $request) {
        // validation 
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        // authenticate user
        $is_active = 1;
        if (\Auth::attempt(['email' => $request->email, 'password' => $request->password, 'is_active' => $is_active])) {
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
                                ->route('get-user-two-fa')
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
                // user doesn't exit - notify user
                $notification = [
                    'message' => 'Login request failed, kindly try again.',
                    'alert-type' => 'error',
                ];

            }
        } else {
            // user authenticated failed - notify user
            $notification = [
                'message' => 'Incorrect email/password combination or account blocked.',
                'alert-type' => 'error',
            ];

            // return user to previous page
            return redirect()
                    ->back()
                    ->with($notification);
        }
    }

    // get 2fa
    public function two_fa (Request $request) {
        // check if user is authenticated 
        if (\Auth::check()) {
            // return view
            return view('v1.user.auth.two_fa');
        }
        // redirect to previous page
        return redirect()
                ->back();
        
    }

    // post 2fa
    public function post_two_fa (Request $request) {
        // validation
        $this->validate($request, [
            'pin' => 'required|numeric',
        ]);

        // get user
        $user = User::where('email', \Auth::user()->email)
                        ->where('remember_token', $request->pin);

        // check if record exist
        if ($user->count() > 0) {
            // record exist - db record
            $del_token = [
                'remember_token' => null
            ];

            $update_user = $user->update($del_token);

            // check if update was successful
            if ($update_user) {
                // update successful - set user 2fa authenticated
                $request->session()->put('two_fa', 1);

                // register user activity
                $activity = 'Logged in.';
                app('App\Http\Controllers\Helper')->user_activity($activity);

                return redirect()
                        ->route('get-user-dashboard');
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



    // get register
    public function register (Request $request) {
        // return view
        return view('v1.user.auth.register');
    }

    // post register
    public function postRegister (Request $request) {
        // validation
        $this->validate($request, [
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|regex:/^[a-zA-Z\0-9\._*@]*$/',
        ]);

        // save credentials to session
        $request->session()->put('email', strtolower($request->email));
        $request->session()->put('password', $request->password);

        // redirect user to setp two
        return redirect()
                ->route('get-user-register-step-two');
    }

    // get register step 2
    public function register_step_two (Request $request) {
        // check if user passed step 1
        if (!empty($request->session()->get('email')) && !empty($request->session()->get('password'))) {
            // step 1 registration completed - return step 2 view
            $gender = Gender::all();
            return view('v1.user.auth.register_step_two', ['gender' => $gender]);
        }
        return redirect()
                ->back();
    }

    // post register step 2
    public function post_register_step_two (Request $request) {
        // validation
        $this->validate($request, [
            'fname'  => 'required|regex:/^[a-zA-Z\s]*$/',
            'gender' => 'required|numeric',
            'dob' => 'required|date',
        ]);

        // store credentials in session
        $request->session()->put('fname', strtolower($request->fname));
        $request->session()->put('gender', $request->gender);
        $request->session()->put('dob', $request->dob);

        if (!empty($request->session()->get('fname')) && !empty($request->session()->get('gender')) && !empty($request->session()->get('dob')) ) {
            // step two inout fields filled - redirect user to step 3
            return redirect()
                    ->route('get-user-register-three');
        } else {
            // input error occured - notify user
            $notification = [
                'message' => 'An error has occured, kindly try again.',
                'alert-type' => 'error',
            ];

            return redirect()
                    ->back()
                    ->with($notification);
        }
    }

    // get register step three
    public function register_step_three (Request $request) {
        // check if user passed step 3
        if (!empty($request->session()->get('fname')) && !empty($request->session()->get('gender')) && !empty($request->session()->get('dob')) ) {
            // user passed step 2 - return step 3
            return view('v1.user.auth.register_step_three');
        }
        return redirect()
                ->route('get-user-register');
    }

    // post register step theee
    public function post_register_step_three (Request $request) {
        // validation
        $this->validate($request, [
            'country' => 'required|alpha',
            'state' => 'required|alpha',
            'address' => 'required|regex:/^[a-zA-Z\s\0-9\,\.]*$/'
        ]);

        // save user credentials in variables
        $email = $request->session()->get('email');
        $fname = $request->session()->get('fname');
        $gender = $request->session()->get('gender');
        $dob =$request->session()->get('dob');
        $password = $request->session()->get('password');
        $country = strtolower($request->country);
        $state = strtolower($request->state);
        $address = strtolower($request->address);

        // create new user
        $user = new User();
        $user->full_name = $fname;
        $user->email = $email;
        $user->gender_id = $gender;
        $user->dob = $dob;
        $user->country = $country;
        $user->state = $state;
        $user->address = $address;
        $user->password = \Hash::make($password);
        $user_is_active = 1;

        $save_user = $user->save();

        // check if user record was saved
        if ($save_user) {
            // user record saved - clear session record
            $request->session()->forget('email');
            $request->session()->forget('fname');
            $request->session()->forget('gender');
            $request->session()->forget('dob');
            $request->session()->forget('password');

            // log user in
            if (\Auth::attempt(['email' => $email, 'password' => $password, 'is_active' => 1])) {
                // user logged in - send notification
                $notification = app('App\Http\Controllers\Helper')->send_notification();

                // check if notification was sent
                if ($notification) {
                    // notifiction sent - record activity -  redirect user to dashboard
                    $activity = 'Signed up.';
                    app('App\Http\Controllers\Helper')->user_activity($activity);

                    return redirect()
                            ->route('get-user-dashboard');
                } else {
                    // notification not sent -  send again and log user in
                    $notification = app('App\Http\Controllers\Helper')->send_notification();

                    return redirect()
                            ->route('get-user-dashboard');
                }
            } else {
                return 'Login error occured!';
            }
            

        } else {
            // error occured - notify user
            $notification = [
                'message' => 'An error has occured, kindly try again.',
                'alert-type' => 'error',
            ];

            return redirect()
                    ->back()
                    ->with($notification);
        }
    }

    // logout
    public function user_logout (Request $request ) {
        \Auth::logout();

        // redirect user to login page
        return redirect()
                ->route('get-user-login');
    }
}
