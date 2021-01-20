<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Investment;
use App\PropertyListing;
use App\UserInvestment;
use Illuminate\Support\Facades\DB;

class AdminInvestmentController extends Controller
{
    // gets index page
    public function index(Request $request) {
        // get all investment
        $investment = Investment::orderBy('id', 'desc')->paginate(10);
        return view('v1.admin.authenticated.investment.index', ['investments' => $investment]);
    }

    // activate/deactivate investment rentage
    public function change_rentage_status(Request $request, $id) {
        try {
            // decrypt id
            $id = \Crypt::decrypt($id);

            $investment = Investment::where('id', $id);  // get investment record

            // check if investment record exist
            if ($investment->count() > 0) {
                // investment record found - check if investment rentage is on/off
                if ($investment->pluck('is_rented')->first()) {
                    // investment rentage is on - turn off
                    $change_status = [
                        'is_rented' => 0,
                    ];

                    $update_investment = $investment->update($change_status);  // update investment

                    // check if investment was updated
                    if ($update_investment) {
                        // investment rentage turned off - notify admin
                        $notification = [
                            'message' => 'Investment rentage turned off',
                            'alert-type' => 'success',
                        ];

                        return redirect()
                                ->back()
                                ->with($notification);
                    } else {
                        // investment update failed - notify admin
                        $notification = [
                            'message' => 'An error has occured, kindly try again.',
                            'alert-type' => 'error',
                        ];

                        return redirect()
                                ->back()
                                ->with($notification);
                    }
                } else {
                    // investment rentage is off - turn on
                    $change_status = [
                        'is_rented' => 1,
                    ];

                    $update_investment = $investment->update($change_status);  // update investment

                    // check if investment was updated
                    if ($update_investment) {
                        // investment rentage turned on - notify admin
                        $notification = [
                            'message' => 'Investment rentage turned on.',
                            'alert-type' => 'success',
                        ];

                        return redirect()
                                ->back()
                                ->with($notification);
                    } else {
                        // investment update failed - notify admin
                        $notification = [
                            'message' => 'An error has occured, kindly try again.',
                            'alert-type' => 'error',
                        ];

                        return redirect()
                                ->back()
                                ->with($notification);

                    }
                }
            } else {
                // investment record not found - notify admin
                $notification = [
                    'message' => 'Investment record not found.',
                    'alert-type' => 'error',
                ];

                return redirect()
                        ->back()
                        ->with($notification);
            }

        } catch (\Throwable $th) {
            // throws invalid payload error
            $notification = [
                'message' => Investment::where('id', \Crypt::decrypt($id))->count(),
                'alert-type' => 'error',
            ];

            return redirect()
                    ->back()
                    ->with($notification);
        }
    }

    // investment search
    public function search_investment(Request $request) {
        // validation
        $this->validate($request, [
            'search' => 'required|regex:/^[a-zA-Z\s]*$/',
        ]);

        // get investment record
        $property = PropertyListing::where('title', 'LIKE', '%'.$request->search.'%');

        // check if record exist
        if($property->count() > 0) {
            // property exit - get investment record
            $investment = Investment::where('property_listing_id', $property->pluck('id')->first())->paginate();
            
            // check if property exit as investment
            if($investment->count() > 0 ) {
                // property exist as an investment - return result
                return view('v1.admin.authenticated.investment.index', ['investments' => $investment]);
            } else {
                // property doesn't exist as an investment - notify admin
                $notification = [
                    'message' => 'Investment record not found.',
                    'alert-type' => 'error',
                ];

                return redirect()
                        ->back()
                        ->with($notification);
            }
        } else {
            // property doesn't exist - notify admin
            $notification = [
                'message' => 'Investment record not found.',
                'alert-type' => 'error',
            ];

            return redirect()
                    ->back()
                    ->with($notification);
        }
    }

    // get add investment
    public function add_investment(Request $request) {
        // get property that is not already an investment
        $property = DB::table('property_listings')
                        ->join('investments as investments', 'property_listings.id', '=','investments.property_listing_id', 'left outer')
                        ->where('investments.property_listing_id', null)
                        ->get();

        return view('v1.admin.authenticated.investment.add', ['properties' => $property]);
    }

    // post add investment
    public function post_add_investment(Request $request) {
        // validation
        $this->validate($request, [
            'slot' => 'required|numeric',
            'property' => 'required|regex:/^[a-zA-Z\s\0-9]*$/',
            'amount' => 'required|numeric',
        ]);

        // get investment record where the name matches
        $property = PropertyListing::where('title', 'LIKE', $request->property)->get();

        // check if property record was retrieved
        if ($property->count() > 0) {
            // property record found - create new investment
            $investment = new Investment();  // create new investmetn instance
            $investment->property_listing_id = $property->pluck('id')->first();  // sets investment property_listing id
            $investment->amount_per_slot = $request->amount;  // sets investment amount per slot
            $investment->avail_slot = $property->pluck('slot')->first();  // sets default available slot

            $save_investment_record = $investment->save(); // save investment

            // check if investment was saved
            if ($save_investment_record) {
                // investment record saved - redirect user to investment record list - notify admin
                $notification = [
                    'message' => 'Investment added successfully.',
                    'alert-type' => 'success',
                ];

                return redirect()
                        ->route('get-admin-investment')
                        ->with($notification);
            } else {
                // investment record not saved -  notify admin
                $notification = [
                    'message' => 'An error has occured, kindly try again.',
                    'alert-type' => 'error',
                ];

                return redirect()
                        ->back()
                        ->with($notification);
            }

        } else {
            // property record not - notify admin
            $notification = [
                'message' => 'An error has occured, kindly try again.',
                'alert-type' => 'error',
            ];

            return redirect()
                    ->back()
                    ->with($notification);
        }

    }

    // view specific investment
    public function view_investment(Request $request, $id) {
        try {
            // dcrypt id
            $id = \Crypt::decrypt($id);

            // get investment record
            $investment = Investment::find($id);


            // check if investment record was found
            if($investment->count() > 0) {
                // investment record found -  get users that invested in the selected property
                $user_investment = UserInvestment::where('investment_id', $investment->id)->paginate(5);

                // check if user investment record was found
                if ($user_investment->count() > 0) {
                    // user investment record found - return view
                    return view('v1.admin.authenticated.investment.view', ['investment' => $investment, 'user_investment' => $user_investment]);
                } else {
                    // user investment record not found.
                    return view('v1.admin.authenticated.investment.view', ['investment' => $investment, 'user_investment' => Null]);
                }
                
            } else {
                // investment record not found -  redirect admin to previous page - notify admin
                $notification = [
                    'message' => 'Invalid investment selected',
                    'alert-type' => 'error',
                ];

                // redirect user to request page
                return redirect()
                        ->back()
                        ->with($notification);

            }
        } catch (\Throwable $th) {
            //throws if invalid payload error occurs
            $notification = [
                'message' => 'Invalid Investment payload',
                'alert-type' => 'error',
            ];

            return redirect()
                    ->back()
                    ->with($notification);
        }
    }
}
