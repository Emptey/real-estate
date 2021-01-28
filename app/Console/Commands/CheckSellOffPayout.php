<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Investment;
use App\UserInvestment;
use App\SellOffPayout;

class CheckSellOffPayout extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:checkselloffpayout';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command checks for investment due for sell off payout and return its investors record.';

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
        // get current date
        $today = date('Y-m-d');
        
        // get all investment whoses due date is todday
        $investment = Investment::where('is_filled', 1)
                        ->where('is_complete', 1)
                        ->where('is_active', 1)
                        ->whereDate('sell_off_payment_date', $today)
                        ->get();

        // check if investment was found
        if ($investment->count() > 0) {
            // investment found - loop thorugh investment
            foreach ($investment as $investments) {
                // get all user investment with investment id
                $user_investment = UserInvestment::where('investment_id', $investments->id)
                                    ->where('is_paid', 1)
                                    ->get();

                // check if records exits
                if ($user_investment->count() > 0) {
                    // user investment found  - loop through record(s)
                    foreach ($user_investment as $user_investments) {
                        // add user investment record to sell_off_payout table
                        $sell_off_payout = new SellOffPayout();
                        // add records
                        $sell_off_payout->user_id       = $user_investments->user_id;  // sets user id
                        $sell_off_payout->investment_id = $user_investments->investment_id; // sets investment id
                        $sell_off_payout->amount_paid   = app('App\Http\Controllers\Helper')
                                                                ->calculate_roi(
                                                                    $user_investments
                                                                    ->amount, $investments
                                                                    ->property_listing
                                                                    ->sell_off_profit_percent
                                                                );
                        // save sell off payout record(s)
                        $save_records = $sell_off_payout->save();

                        // check if records were saved
                        if ($save_records) {
                            // user sell off payout records saved - deactivate investment
                            $update_investment_record = $investments->update(app('App\Http\Controllers\Helper')::deactivator());
                            
                            // check if investment was updated.
                            if ($update_investment_record) {
                                // investment record updated - 200
                                echo 'ok - 200';
                            } else {
                                // investment record update failed
                                echo 'error - 400';
                            }
                        } else {
                            // an error occured. record not saved
                        }

                    }
                   
                    
                } else {
                    // no investment found
                    echo 'No investment found.';
                }
            }
            // end loop
        } else {
            // no user investment record found.
            echo 'No investment found.';
        }

    }
}
