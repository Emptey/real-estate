<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PropertyListing extends Model
{
    // relationship btw property listting and property image
    public function property_images() {
        return $this->hasMany('App\PropertyImages');
    }

    // relationship btw propertty listing and investment
    public function investment() {
        return $this->hasOne('App\Investment');
    }
}
