<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\UserInvestment;
use App\Investment;


class UserChartController extends Controller
{
    // gets user rentage record
    public function get_user_rentage_record (Request $request, $id) {
        try {
            // decrypt id
            $id = \Crypt::decrypt($id);

            $chart_property = DB::table('rent_payouts')
                            ->orderBy('id', 'desc')
                            ->where('user_id', $id)
                            ->get()
                            ->groupBy(function($val){
                            return Carbon::parse($val->created_at)
                                    ->format('Y-m');
            });

            return response()->json($chart_property, 200);

        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    // get user investment rate
    public function get_user_investment_rate (Request $request, $id) {
        try {
            // decrypt id
            $id = \Crypt::decrypt($id);

            $record = DB::table('user_investments')
                            ->orderBy('id', 'desc')
                            ->where('user_id', $id)
                            ->get()
                            ->groupBy(function($val){
                                return Carbon::parse($val->created_at)
                                        ->format('Y-m');
                            });

            return response()->json($record, 200);

        } catch (\Throwable $th) {
            // invalid payload provided, user not logged in
        }
    }

    public function investment_status (Request $request, $id) {
        try {
            // decrypt id
            $id = \Crypt::decrypt($id);

            // get completed user investment
            $user_investment_completed = DB::table('user_investments')
                        ->join('investments', 'user_investments.investment_id', '=', 'investments.id')
                        ->where('user_investments.user_id', $id)
                        ->where('investments.is_active', 0)
                        ->where('investments.is_complete', 1)
                        ->where('investments.is_filled', 1)
                        ->count();

            // get user active investment
            $user_investment_active = DB::table('user_investments')
                        ->join('investments', 'user_investments.investment_id', '=', 'investments.id')
                        ->where('user_investments.user_id', $id)
                        ->where('investments.is_active', 1)
                        ->where('investments.is_filled', 1)
                        ->count();

            return response()->json(['active' => $user_investment_active, 'completed' => $user_investment_completed]);
            
        } catch (Throwable $th) {
            // invalid payload provided, user not logged in.
        }
    }


}
