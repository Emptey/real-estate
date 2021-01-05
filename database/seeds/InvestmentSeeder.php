<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class InvestmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // today's date
        $today = date('Y/m/d');

        for($i = 0; $i < 10; $i++) {
            DB::table('investments')->insert([
                'property_listing_id' => mt_rand(1, 11),
                'avail_slot' => mt_rand(1, 5),
                'amount_per_slot' => mt_rand(2000, 5000),
                'first_rent_payment_date' => date('Y/m/d'),
                'next_rent_payment_date' => date($today, strtotime('+365 days')),
                'last_rent_payment_date' => date($today, strtotime('+600 days')),
                'sell_off_payment_date' => date($today, strtotime('+900 days')),
                'expiry_date' => date($today, strtotime('+910 days')),
                'is_rented' => mt_rand(0, 1),
                'is_filled' => mt_rand(0,1),
                'is_complete' => mt_rand(0, 1),
            ]);
        }
    }
}
