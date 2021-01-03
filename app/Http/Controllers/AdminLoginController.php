<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
                return redirect()
                        ->route('get-dashboard');
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

    // logout
    public function logout() {
        \Auth::logout();  // destroying session
        return redirect()
                ->route('admin-login');
    }
}
    
