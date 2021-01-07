<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PropertyListingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i=0; $i < 10; $i++) { 
            DB::table('property_listings')->insert([
                'title' => Str::random(10),
                'description' => Str::random(10),
                'address' => Str::random(10),
                'bedroom' => mt_rand(1, 10),
                'bathroom' => mt_rand(1, 10),
                'toilet' => mt_rand(1, 10),
                'slot' => mt_rand(1, 10),
                'duration' => mt_rand(2, 10),
                'purchase_amount' => mt_rand(10000, 90000),
                'mngt_fee' => mt_rand(1000, 9000),
                'sell_off_price' => mt_rand(10000, 90000),
                'sell_off_profit_percent' => mt_rand(1, 10),
                'rentage_price' => mt_rand(10000, 50000),
                'is_rentable' => mt_rand(0, 1),
                'is_active' => mt_rand(0, 1),
            ]);
        }
    }
}
