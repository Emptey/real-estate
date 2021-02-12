<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\UserActivity;

class UserProfileController extends Controller
{
    // index / profile
    public function index (Request $request) {
         // get user activity
         $activity = UserActivity::where('user_id', \Auth::user()->id)->orderBy('id', 'desc')->limit(2)->get();

         // check if record was found
         if ($activity->count() > 0) {
             $activity =  $activity;
         } else {
             $activity = null;
         }
        // return view
        return view('v1.user.authenticated.profile.index', ['activity' => $activity]);
    }

    // get settings
    public function settings (Request $request) {
        // return view
        return view('v1.user.authenticated.profile.settings');
    }
}
