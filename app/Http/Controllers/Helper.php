<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\UserActivity;
use App\Notification;

class Helper extends Controller
{
    // activator
    public static function activator() {
        $activate = [
            'is_active' => 1,
        ];

        return $activate;
    }

    // deactivator
    public static function deactivator () {
        $deactivate = [
            'is_active' => 0,
        ];

        return $deactivate;
    }
    // generates random number
    public static function random_number() {
        $random_number = mt_rand(10000, 90000);
        return $random_number;
    }

    // generates random name initial style
    public static function generate_initial_style() {
        $random = mt_rand(1, 5);
        return 'initial-'.$random;
    }

    // gets user role
    public static function user_role($user) {
        if($user->is_staff && !$user->is_super) {
            return 'staff';
        } elseif($user->is_staff && $user->is_super) {
            return 'super user';
        } else {
            return 'user';
        }
    }

    // gets just date
    public static function justDate($date) {
        return substr($date, 0, 10);
    }

    // gets user status
    public function getStatus ($record) {
        if($record->is_active) {
            return '<i class="fa fa-check-circle text-success"></i>';
        } else {
            return '<i class="fa fa-times-circle text-danger"></i>';
        }
    }

    // gets admin options button
    public function getButton($option) {
        if($option->is_active) {
            return 'btn btn-danger';
        } else {
            return 'btn btn-success';
        }
    }

    // enable/disable button based on admin super-admin status
    public function superAdminStatus() {
        // check user super admin status
        if (\Auth::user()->is_staff && \Auth::user()->is_super) {
            // user has super-admin privilege
            return '';
        } else {
            // user has no super-admin privilege
            return 'disabled';
        }
    }

    // records user activity
    public function user_activity($activity) {
        // create a new user activity
        $user_activity = new UserActivity();
        $user_activity->user_id = \Auth::user()->id;  // set user id
        $user_activity->activity = $activity;

        // save user activity
        $save_activity = $user_activity->save();

        // check if activity was saved
        if ($save_activity) {
            return true;
        } else {
            return false;
        }
    }

    // calculate investment roi
    public function calculate_roi($amount, $percentage) {
        // compute user profit
        $roi = (($amount / 100) * $percentage) + $amount;
        return $roi;
    }

    // calculate next rent payment circle
    public function next_rent_calculation() {
        $next_payment_date = date('Y-m-d', strtotime('+ 360 days'));
        return $next_payment_date;
    }

    // send notification
    public function send_notification ($title = 'Welcome', $message = 'Welcome to Eminence global properties. Feel free to contact us at anytime, we\'re here to serve you always.' ) {
        // create notification instance
        $notification = new Notification();

        // assign notification values
        $notification->user_id = \Auth::user()->id;
        $notification->title = $title;
        $notification->message = $message;
        $notification->is_active = 1;

        // save notification
        $save = $notification->save();

        // check if notification was saved
        if ($save) {
            // notification saved - return true
            return true;

        } else {
            // notification sending failed - return false;
            return false;

        }
    }

}
