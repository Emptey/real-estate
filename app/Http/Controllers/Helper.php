<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Helper extends Controller
{
    // generates random number
    public static function random_number() {
        $random_number = mt_rand(10000, 90000);
        return $random_number;
    }
}
