<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Investment extends Model
{
    // relationship btw investment & property_listing
    public function property_listing() {
        return $this->belongsTo('App/PropertyListing');
    }
}
