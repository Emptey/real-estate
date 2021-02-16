<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\UserActivity;
use App\Notification;
use App\Gender;
use App\UserInvestment;
use App\RentPayout;
use App\SellOffPayout;

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

    // gender avatar function
    public function gender_avatar () {
        // setup avatars
        $female_avatar = 'user_female.png';
        $male_avatar = 'user_male.png';

        // check user gender
        $gender = Gender::where('id', \Auth::user()->gender_id);

        // check if gender exit
        if ($gender->count() > 0) {
            // gender exit - check gender type
            if ($gender->pluck('gender')->first() == 'female') {
                // gender = female - return avar
                return $female_avatar;

            } else if ($gender->pluck('gender')->first() == 'male') {
                // gender = male - return avatar
                return $male_avatar;
            }

        } else {
            // gender doesn't exit retrun default
        }

    }

    // get user investment status
    public function get_user_investment_status ($investment) {
        if ($investment->investment->is_filled === 0) {
            return 'inactive';
        } else if ($investment->investment->is_filled === 1 && $investment->investment->is_complete === 0) {
            return 'active';
        } else if ($investment->investment->is_complete === 1) {
            return 'completed';
        }
    }

    // get user notification colouration
    public function getNotificationColor ($notification) {
        // check if notification is read
        if ($notification->is_read) {
            // notification read
            return 'notification-header';
        } else {
            // notification not read - generate random color
            $random_number = mt_rand(1,3);
            return 'notification-header-'.$random_number;
        }
    }

    // gets user investment outgoing transaction count
    public function get_user_investment_transaction_count ($user_id) {
        // get user investment record count
        $user_investment = UserInvestment::where('user_id', $user_id)->count();

        // check if records exist
        if ($user_investment > 0) {
            // record exist - return user investment count
            return $user_investment;
        } else {
            // record doesn't exist - return 0 as value
            return 0;

        }
    }

    // gets user sell off payout transaction count
    public function get_user_sell_off_transaction_count ($user_id) {
        // get user sell off payout record
        $user_record = SellOffPayout::where('user_id', $user_id)->count();

        // cehck if record was found
        if ($user_record > 0) {
            // record exit - return count value
            return $user_record;
        } else {
            // record doesn't exist - return 0 as count value.
            return 0;
        }
    }

    // gets user rent  transaction count 
    public function  get_user_rent_payout_transaction_count ($user_id) {
        // get user rent payout record
        $user_record = RentPayout::where('user_id', $user_id)->count();

        // cehc if record exist
        if ($user_record > 0) {
            // record exist - return count value
            return $user_record;
        } else {
            // record doesn't exist - return 0 as count value
            return 0;
        }
    }

    // sums two values
    public function sum_numbers () {
        $num1 = $this->get_user_rent_payout_transaction_count(\Auth::user()->id);
        $num2 = $this->get_user_sell_off_transaction_count(\Auth::user()->id);

        $sum = $num1 + $num2;

        return $sum;
    }

    // gets user failed transactions
    public function get_user_failed_transactions ($user_id) {
        $user_record = UserInvestment::where('user_id', $user_id)
                        ->where('is_paid', 0)->count();

        // check if record exist
        if ($user_record > 0) {
            // record exist - return count value
            return $user_record;
        } else {
            // record doesn't exist - return 0 as count
            return 0;
        }
    }

}
