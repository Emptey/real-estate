<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PropertyImages extends Model
{
    // relationship btw property image and property listing
    public function property_listings() {
        return $this->belongsTo('App\PropertyListing');
    }
}
