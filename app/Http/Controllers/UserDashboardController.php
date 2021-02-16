<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\UserInvestment;

class UserDashboardController extends Controller
{
    // get index 
    public function index (Request $request) {
        // get user investment
        $get_investment = UserInvestment::where('user_id', \Auth::user()->id)->get();

        // check if investment record exist
        if ($get_investment->count() > 0) {
            // record found
            $get_investment = $get_investment;
        } else {
            // record not found.
            $get_investment = null;
        }
        // return view
        return view('v1.user.authenticated.index', ['user_investment' => $get_investment]);
    }
}
