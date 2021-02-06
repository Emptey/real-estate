<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
        return redirect()
                ->route('get-user-two-fa');
    }

    // get 2fa
    public function two_fa (Request $request) {
        // return view
        return view('v1.user.auth.two_fa');
    }

    // get register
    public function register (Request $request) {
        // return view
        return view('v1.user.auth.register');
    }

    // post register
    public function postRegister (Request $request) {
        return redirect()
                ->route('get-user-register-step-two');
    }

    // get register step 2
    public function register_step_two (Request $request) {
        return view('v1.user.auth.register_step_two');
    }

    // post register step 2
    public function post_register_step_two (Request $request) {
        return redirect()
                ->route('get-user-register-three');
    }

    // get register step three
    public function register_step_three (Request $request) {
        return view('v1.user.auth.register_step_three');
    }
}
