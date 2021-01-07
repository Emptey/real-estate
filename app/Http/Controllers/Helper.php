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

    // generates random name initial style
    public static function generate_initial_style() {
        $random = mt_rand(1, 5);
        return 'initial-'.$random;
    }
}
