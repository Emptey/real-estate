<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RentPayout extends Model
{
    // relationship btw rent payout an user
    public function user() {
        return $this->belongsTo('App\User');
    }

    // relationship btw rent payout and investment
    public function investment() {
        return $this->belongsTo('App\Investment');
    }
}
