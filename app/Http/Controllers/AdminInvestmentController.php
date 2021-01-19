<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Investment;

class AdminInvestmentController extends Controller
{
    // gets index page
    public function index(Request $request) {
        // get all investment
        $investment = Investment::orderBy('id', 'desc')->paginate(5);
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
}
