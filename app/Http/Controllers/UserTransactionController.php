<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\UserInvestment;
use App\RentPayout;
use App\SellOffPayout;
use App\PropertyListing;
use App\Investment;

class UserTransactionController extends Controller
{
    // index
    public function index (Request $request) {
        // get all user investment transactions
        $all_user_investment = UserInvestment::where('user_id', \Auth::user()->id)->orderBy('id', 'desc')->paginate(5);

        // check if user investment transactions exist
        if ($all_user_investment->count() > 0) {
            // record exist - return record
            $all_user_investment = $all_user_investment;
        } else {
            // record doesn't exist -  return null
            $all_user_investment = null;
        }

        // gets user incoming transactions
        $incoming = app('App\Http\Controllers\Helper')->sum_numbers();

        // gets user outgoing transactions
        $outgoing = app('App\Http\Controllers\Helper')->get_user_investment_transaction_count(\Auth::user()->id);

        // gets user failed outgoing transactions
        $failed_outgoing = app('App\Http\Controllers\Helper')->get_user_failed_transactions(\Auth::user()->id);

        // return view
        return view('v1.user.authenticated.transactions.index', 
            ['incoming' => $incoming, 'outgoing' => $outgoing, 
            'failed_transactions' => $failed_outgoing, 'transactions' => $all_user_investment]);
    }

    // search transaction
    public function search_transaction (Request $request) {
        // validation
        $this->validate($request, [
            'search' => 'required|regex:/^[a-zA-Z\s]*$/',
        ]);

         // gets user incoming transactions
         $incoming = app('App\Http\Controllers\Helper')->sum_numbers();

         // gets user outgoing transactions
         $outgoing = app('App\Http\Controllers\Helper')->get_user_investment_transaction_count(\Auth::user()->id);
 
         // gets user failed outgoing transactions
         $failed_outgoing = app('App\Http\Controllers\Helper')->get_user_failed_transactions(\Auth::user()->id);

        // get user investments
        $user_investment = UserInvestment::where('user_id', \Auth::user()->id)->get();

        // record activity
        $activity = 'Conducted transaction search.';
        app('App\Http\Controllers\Helper')->user_activity($activity);

        // check if record exist
        if ($user_investment->count() > 0) {
            // record exit
            $user_investment = $user_investment;
        } else {
            // record doesn't exit
            $user_investment = null;
        }

        // get property
        $property = PropertyListing::where('title', 'LIKE', '%'.$request->search.'%')->get();

        // check if property exist
        if ($property->count() > 0) {
            // property exist - get investment record
            $investment = Investment::where('property_listing_id', $property->pluck('id')->first())->get();

            // check if investment exist
            if ($investment->count() > 0) {
                // investment exist - get user investment record
                $user_investment_record = UserInvestment::where('investment_id', $investment->pluck('id')->first())->paginate();

                // check if investment exit
                if ($user_investment_record->count() > 0) {
                    // investment found in user portfolio - return record
                    return view('v1.user.authenticated.transactions.index',['transactions' => $user_investment_record, 'incoming' => $incoming, 'outgoing' => $outgoing, 
                    'failed_transactions' => $failed_outgoing]);
                } else {
                    // investment doesn't exit in user portfolio
                    $notification = [
                        'message' => 'Transaction not found.',
                        'alert-type' => 'warning',
                    ];

                    return redirect()
                            ->back()
                            ->with($notification);
                }
            } else {
                // investment doesn't yet - notify user
                $notification = [
                    'message' => 'transaction not found.',
                    'alert-type' => 'warning',
                ];

                return redirect()
                        ->back()
                        ->with($notification);

            }
        } else {
            // property doesn't exit - notify user
            $notification = [
                'message' => 'Transaction not found.',
                'alert-type' => 'warning',
            ];

            return redirect()
                    ->back()
                    ->with($notification);
        }
    }
}
