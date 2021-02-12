<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserNotificationController extends Controller
{
    // get index page
    public function index (Request $request) {
        // get notification
        

        // return view
        return view('v1.user.authenticated.notifications.index');
    }
}
