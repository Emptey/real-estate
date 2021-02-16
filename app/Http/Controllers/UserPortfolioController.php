<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\UserInvestment;
use App\PropertyListing;
use App\Investment;
use App\RentPayout;

class UserPortfolioController extends Controller
{
    // index
    public function index (Request $request) {
        // get all user investment
        $all_user_investment = UserInvestment::where('user_id', \Auth::user()->id)->orderBy('id', 'desc')->paginate(10);
        // get user investments
        $user_investment = UserInvestment::where('user_id', \Auth::user()->id)->get();

        // return $user_investment;

        // check if record exist
        if ($user_investment->count() > 0) {
            // record exit
            $user_investment = $user_investment;
        } else {
            // record doesn't exit
            $user_investment = null;
        }
        // return view
        return view('v1.user.authenticated.portfolio.index', ['user_investment' => $user_investment, 'all_user_investment' => $all_user_investment]);
    }

    // search investment
    public function search_portfolio (Request $request) {
        // validation
        $this->validate($request, [
            'search' => 'required|regex:/^[a-zA-Z\s]*$/',
        ]);

        // get user investments
        $user_investment = UserInvestment::where('user_id', \Auth::user()->id)->get();

        // record activity
        $activity = 'Conducted portfolio search.';
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
                    return view('v1.user.authenticated.portfolio.index',['user_investment' => $user_investment, 'all_user_investment' => $user_investment_record ]);
                } else {
                    // investment doesn't exit in user portfolio
                    $notification = [
                        'message' => 'Investment not found.',
                        'alert-type' => 'warning',
                    ];

                    return redirect()
                            ->back()
                            ->with($notification);
                }
            } else {
                // investment doesn't yet - notify user
                $notification = [
                    'message' => 'investment not found.',
                    'alert-type' => 'warning',
                ];

                return redirect()
                        ->back()
                        ->with($notification);

            }
        } else {
            // property doesn't exit - notify user
            $notification = [
                'message' => 'Investment not found.',
                'alert-type' => 'warning',
            ];

            return redirect()
                    ->back()
                    ->with($notification);
        }
    }

    // view transaction
    public function get_investment_portfolio (Request $request, $id) {
        try {
            // decrypt id
            $id = \Crypt::decrypt($id);

            // get user investment record
            $user_investment = UserInvestment::find($id);

            // check if investment exist
            if ($user_investment->count() > 0) {
                // investment found - get transactions on the investment
                $get_investment_transactions = RentPayout::where('user_id', \Auth::user()->id)
                                                ->where('investment_id', $user_investment->investment_id)
                                                ->orderBy('id', 'desc')
                                                ->paginate(5);
                
                // check if transactions exist
                if ($get_investment_transactions->count() > 0) {
                    // investment transaction exist
                    $get_investment_transactions = $get_investment_transactions;
                } else {
                    // investment transactions do not exist
                    $get_investment_transactions = null;
                }

                return view('v1.user.authenticated.portfolio.view', ['user_investment' => $user_investment, 'transactions' => $get_investment_transactions]);
            } else {
                // investment not found - redirect user
                return redirect()
                        ->back();
            }
        } catch (\Throwable $th) {
            //invalid - notify user
            $notification = [
                'message' => 'Invalid investment supplied.',
                'alert-type' => 'error',
            ];

            return redirect()
                    ->back()
                    ->with($notification);
        }
    }
}
