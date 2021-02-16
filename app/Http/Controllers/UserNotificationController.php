<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Notification;

class UserNotificationController extends Controller
{
    // get index page
    public function index (Request $request) {
        // get notification
        $notification = Notification::where('user_id', \Auth::user()->id)->orderBy('id', 'desc')->paginate(10);

        // check if user has notification
        if ($notification->count() > 0) {
            // notification found.
            $notification = $notification;
        } else {
            $notification = null;
        }
        // return view
        return view('v1.user.authenticated.notifications.index', ['notification' => $notification]);
    }
}
