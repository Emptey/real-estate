<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\RentPayout;
use App\SellOffPayout;
class AdminPaymentController extends Controller

{
    // index page
    public function index(Request $request) {
        // get all unpaid rent payout
        $rent_payment = RentPayout::where('is_paid', 0)
                            ->paginate(10);

        // check rent payment returned data
        if ($rent_payment->count() > 0) {
            // data returned - return rent_payment data
            $rent_payment = $rent_payment;
        } else {
            // no data returned - return rent_payment as null
            $rent_payment = null;
        }

        // get all unpaid sell-off payout
        $sell_off_payment = SellOffPayout::where('is_paid', 0)
                                ->paginate(10);

        // check sell_off_payment return data
        if ($sell_off_payment->count() > 0) {
            // data returned - return sell_off_payment
            $sell_off_payment = $sell_off_payment;
        } else {
            // no data returned - return sell_off_payment as null
            $sell_off_payment = null;
        }

        // return view
        return view('v1.admin.authenticated.payment.index', ['rent_payments' => $rent_payment, 'sell_off_payments' => $sell_off_payment]);
    }

    /**
     * options functions
     */
    // pay all
    public function pay_all(Request $request) {
        // validation
        $this->validate($request, [
            'action' => 'required',
        ]);

        // get rentpayment model
        $rent_payout_table = RentPayout::where('is_paid', 0);


        // check the action sent
        if ($request->action == 0 ) {
            // pay all action sent
            if ( $rent_payout_table->count() > 0 ) {
                // there are rent payouts - 
                $new_rent_payout = [
                    'is_paid' => 1,
                ];

                // update db
                $update_rent_paout_table = $rent_payout_table->update($new_rent_payout);

                // check if update was successful
                if($update_rent_paout_table) {
                    // update successful - notify admin
                    $notification = [
                        'message' => 'All rent payouts paid.',
                        'alert-type' => 'success',
                    ];

                    return redirect()
                            ->back()
                            ->with($notification);
                } else {
                    // update unsuccessful -  notify admin
                    $notification = [
                        'message' => 'An error has occured. kindly try again.',
                        'alert-type' => 'error',
                    ];

                    return redirect()
                            ->back()
                            ->with($notification);
                }

            } else {
                // no payouts available - notify
                $notification = [
                    'message' => 'Invalid action. There are no rent payouts',
                    'alert-type' => 'warning',
                ];

                return redirect()
                        ->back()
                        ->with($notification);
            }
            
        } else {
            // another request sent
        }
    }
    /**
     * end function
     */


    //  pay specific user
      // pay specific user
      public function pay_user(Request $request, $id) {
        try {
            // decrypt id and get record
            $id = \Crypt::decrypt($id);

            // find record
            $get_user_record = RentPayout::where('user_id', $id)
                                    ->where('is_paid', 0);

            // check if user record was found
            if ($get_user_record->count() > 0) {
                // record found.
                $new_user_record_payment = [
                    'is_paid' => 1,
                ];

                // update user record
                $update_record = $get_user_record->update($new_user_record_payment);

                // check if update was successfull
                if ($update_record) {
                    // update successful - notify admin
                    $notification = [
                        'message' => 'User marked as paid successfully.',
                        'alert-type' => 'success',
                    ];

                    return redirect()
                            ->back()
                            ->with($notification);

                } else {
                    // update unsuccessful - notify admin
                    $notification = [
                        'message' => 'An error has occured. kindly try again',
                        'alert-type' => 'error',
                    ];

                    return redirect()
                            ->back()
                            ->with($notification);
                }

            } else {
                // no record found - notify admin
                $notification = [
                    'message' => 'User not found.',
                    'alert-type' => 'error',
                ];

                return redirect()
                        ->back()
                        ->with($notification);
            }

        } catch (\Throwable $th) {
            //payload error - notify admin
            $notification = [
                'message' => 'Invalid user selected.',
                'alert-type' => 'error',
            ];

            return redireet()
                    ->back()
                    ->with($notification);

        }
    }

    // pay specific user sell-off
    public function pay_user_sell_off(Request $request, $id) {
        try {
            // decrypt id..
            $id = \Crypt::Decrypt($id);

            // find user record in sell_off table
            $sell_off_table = SellOffPayout::where('user_id', $id);

            // check if record exist
            if ($sell_off_table->count() > 0) {
                // record exist
                $new_record = [
                    'is_paid' => 1,
                ];

                // update record
                $update_record = $sell_off_table->update($new_record);

                // check if record was updated
                if ($update_record) {
                    // record updated -  notify admin
                    $notification = [
                        'message' => 'User marked as paid successfully.',
                        'alert-type' => 'success',
                    ];

                    return redirect()
                            ->back()
                            ->with($notification);

                } else {
                    // update failed - notify admin
                    $notification = [
                        'message' => 'An error has occured. Kindly try again.',
                        'alert-type' => 'error',
                    ];

                    return redirect()
                            ->back()
                            ->with($notification);

                }
            } else {
                // record not found. - notify admin
                $notification = [
                    'message' => 'user not found. Try again.',
                    'alert-type' => 'warning',
                ];

                return redirect()
                        ->back()
                        ->with($notification);
            }

        } catch (\Throwable $th) {
            //throw error - invalid payload
            $notification = [
                'message' => 'Invalid user selected',
                'alert-type' => 'error',
            ];

            return redirect()
                    ->back()
                    ->with($notification);
        }
    }

    // pay all users sell_off payout
    public function pay_all_users_sell_off(Request $request) {
        // validation
        $this->validate($request, [
            'action' => 'required',
        ]);

        // check action selected
        if ($request->action == 0) {
            // pay all action selected - execute pay all command
            $sell_off_table = SellOffPayout::where('is_paid', 0);

            // check if record was found
            if ($sell_off_table->count() > 0) {
                // record found - update records
                $new_record = [
                    'is_paid' => 1,
                ];

                // update record
                $update_record = $sell_off_table->update($new_record);

                // check if record was updated
                if ($update_record) {
                    // record updated - notify admin
                    $notification = [
                        'message' => 'All unpaid investors marked as paid.',
                        'alert-type' => 'success',
                    ];

                    return redirect()
                            ->back()
                            ->with($notification);
                            
                } else {
                    // record not updated - notify admin
                    $notification = [
                        'message' => 'An error has occured. Kindly try again.',
                        'alert-type' => 'error',
                    ];

                    return redirect()
                            ->back()
                            ->with($notification);
                }
            } else {
                // no record found - notify admin
                $notification = [
                    'message' => 'No users were found to be marked as paid.',
                    'alert-type' => 'warning',
                ];

                return redirect()
                        ->back()
                        ->with($notification);

            }
        } else {
            // another action selected
        }
    }

}
