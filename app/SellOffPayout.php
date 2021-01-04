<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SellOffPayout extends Model
{
    // relationship btw sell out paout and user
    public function user() {
        return $this->belongsTo('App\User');
    }

    // relatiosnhip btw sell out pay out and investment
    public function investment() {
        return $this->belongsTo('App\Investment');
    }
}
