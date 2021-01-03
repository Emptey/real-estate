<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    // index
    public function index() {
        return view('v1.admin.authenticated.index');
    }
}
