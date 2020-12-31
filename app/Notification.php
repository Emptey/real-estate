<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    // relationship between notification and user
    public function user() {
        return $this->belongsTo('App\User');
    }
}
