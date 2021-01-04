<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Investment extends Model
{
    // relationship btw investment & property_listing
    public function property_listing() {
        return $this->belongsTo('App/PropertyListing');
    }

    // relationship btw investment and user investment
    public function user_investment() {
        return $this->hasMany('App\UserInvestment');
    }

    // relationship btw investment and rent payout
    public function rent_payout() {
        return $this->hasMany('App\RentPayout');
    }

    // relationship btw investment and sell off payout
    public function sell_off_payout() {
        return $this->hasMany('App\SellOffPayout');
    }
}
