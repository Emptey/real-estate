<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Gender extends Model
{
    // relationship between gender and user
    public function user(){
        return $this->hasMany('App\User');
    }
}
