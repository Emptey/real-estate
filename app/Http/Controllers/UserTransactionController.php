<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserTransactionController extends Controller
{
    // index
    public function index (Request $request) {
        // return view
        return view('v1.user.authenticated.transactions.index');
    }
}
