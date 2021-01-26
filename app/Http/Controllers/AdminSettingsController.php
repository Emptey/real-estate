<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\UserActivity;

class AdminSettingsController extends Controller
{
    // index page
    public function index (Request $request) {
        $my_activity = UserActivity::where('user_id', \Auth::user()->id)
                        ->orderBy('id', 'desc')->limit(8)->get();

        // return index page
        return view('v1.admin.authenticated.settings.index', ['activities' => $my_activity]);
    }
}
