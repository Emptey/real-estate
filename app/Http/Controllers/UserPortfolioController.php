<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserPortfolioController extends Controller
{
    // index
    public function index (Request $request) {
        // return view
        return view('v1.user.authenticated.portfolio.index');
    }

    // view transaction
    public function get_investment_portfolio (Request $request, $id) {
        try {
            // decrypt id
        } catch (\Throwable $th) {
            //invalid - notify user
        }
    }
}
