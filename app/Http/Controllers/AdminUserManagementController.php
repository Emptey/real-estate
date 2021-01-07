<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class AdminUserManagementController extends Controller
{
    // index page
    public function index (Request $request) {
        // get all users
        $user = User::all();
        return view('v1.admin.authenticated.user.index');
    }
}
