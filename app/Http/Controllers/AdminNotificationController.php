<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Notification;
use App\User;

class AdminNotificationController extends Controller
{
    // index page
    public function index(Request $request) {
        // return view
        return view('v1.admin.authenticated.notification.index');
    }

    // post notifiction
    public function post_notification(Request $request) {
        // validation
        $this->validate($request, [
            'title' => 'required|regex:/^[a-zA-Z\s\0-9]*$/',
            'message' => 'required|regex:/^[a-zA-Z\s\0-9\.\,]*$/',
        ]);

        // get all users
        $users = User::all();

        // check if records were returned
        if (!is_null($users)) {
            // records returned - loop through record
            foreach($users as $user){
                // create new notification
                $new_notification           = new Notification();
                $new_notification->user_id  = $user->id;  // sets user_id / recipient
                $new_notification->title    = strtolower($request->title);  // sets notification title
                $new_notification->message  = strtolower($request->message);  // sets notification message

                // save notification
                $new_notification->save();
            }

            // notify admin of notification being saved
            $notification = [
                'message' => 'Notification saved successfully.',
                'alert-type' => 'success',
            ];

            return redirect()
                    ->back()
                    ->with($notification);
        } else {
            // no record found/returned - notify admin
            $notification = [
                'message' => 'There are curently no users to send notification to.',
                'alert-type' => 'warning',
            ];

            // redirect user to previous page
            return redirect()
                    ->back()
                    ->with($notification);
        }
    }
}
