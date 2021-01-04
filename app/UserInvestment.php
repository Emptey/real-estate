<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserInvestment extends Model
{
    // relationship btw user investment and investment
    public function investment () {
        return $this->belongsTo('App\Investment');
    }

    // relationship btw user investment and user
    public function user() {
        return $this->belongsTo('App\User');
    }

}
