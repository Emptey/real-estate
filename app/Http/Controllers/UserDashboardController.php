<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserDashboardController extends Controller
{
    // get index 
    public function index (Request $request) {
       
        // return view
        return view('v1.user.authenticated.index');
    }
}
