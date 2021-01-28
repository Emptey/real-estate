<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Investment;
use App\RentPayout;
use App\UserInvestment;

class CheckRentPayout extends Command

{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:checkrentpayout';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'The command checks if there are rentage payouts to be made';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $today = Date('Y-m-d');  // gets today's date
        // get investment with today being the next_payout_date
        $investment = Investment::where('is_rented', 1)
                        ->where('is_filled', 1)
                        ->where('is_active', 1)
                        ->where('is_complete', 0)
                        ->whereDate('next_rent_payment_date', $today)
                        ->get();

        // check if investments were found
        if ($investment->count() > 0) {
            // investment found - loop through gotten investment(s)
            foreach($investment as $investments) {
                // get users that invested in the investment
                $user_investment = UserInvestment::where('is_paid', 1)
                                    ->where('investment_id', $investments->id)
                                    ->get();


                // loop through all users record
                foreach($user_investment as $user_investments) {
                    // create new user rent payout
                    $rent_payout                = new RentPayout();
                    $rent_payout->user_id       = $user_investments->user_id;  // sets user id
                    $rent_payout->investment_id = $user_investments->investment_id;  // sets investment id
                    $rent_payout->amount_paid   = app('App\Http\Controllers\Helper')->calculate_roi($user_investments->amount, $investments->property_listing->rentage_profit_percent);
                    $rent_payout->is_paid       = 0;  // sets is_paid

                    // save record
                    $rent_payout->save();
                }
                // end inner foreach

                // check investment next payment date and update record
                if($investments->next_rent_payment_date < $investments->last_rent_payment_date) {
                    // investment is still active - update investment next rent payment date
                    $investments->update(['next_rent_payment_date' => app('App\Http\Controllers\Helper')->next_rent_calculation()]);
                } else if($investments->next_rent_payment_date >= $investments->last_rent_payment_date) {
                    // investment has expired
                    echo 'Not updated';
                }

            }

            // end outer foreach
        } else {
            // no investment found.
            echo 'No record found.';
        }
    }
}
