<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserActivity extends Model
{
    protected $guarded = ['id'];
    // relationship btw user activity and user
    public function user() {
        return $this->belongsTo('App\User');
    }
}
