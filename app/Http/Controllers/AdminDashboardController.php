<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use LaravelDaily\LaravelCharts\Classes\LaravelChart;  // importing laravel js chart
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\User;
use App\PropertyListing;
use App\Investment;
use App\UserInvestment;

class AdminDashboardController extends Controller
{
    // index
    public function index() {
        // user registration chart
        $chart_options = [
            'chart_title' => 'Users by months',
            'report_type' => 'group_by_date',
            'model' => 'App\User',
            'group_by_field' => 'created_at',
            'group_by_period' => 'month',
            'chart_type' => 'bar',
            'filter_field' => 'created_at',
            'filter_days' => 30, // show only last 30 days

            'conditions'            => [
                ['name' => 'Users by Month', 'backgroundColor' => 'rgba(255, 99, 132, 0.2)', 'borderColor' => 'rgba(255,99,132,1)', 'color' => 'black'],
            ],
        ];

        $chart1 = new LaravelChart($chart_options);

        // gettting all investment purchase record for chart
        $user_investment = DB::table('user_investments')
                ->where('is_paid', 1)
                ->orderBy('id', 'desc')
                ->get()
                ->groupBy(function($val){
                    return Carbon::parse($val->created_at)
                            ->format('Y-m');
                });

        // getting number of listing properties
        $listed_properties = PropertyListing::where('is_active', 1)
                                                ->count();

        // getting active investment
        $active_investment = Investment::where('is_active', 1)->count();
        
        // getting completed investment
        $completed_investment = Investment::where('is_active', 0)
                                                ->where('is_complete', 1)
                                                ->count();
        
        // getting rented properties
        $rented_properties = Investment::where('is_active', 1)
                                            ->where('is_rented', 1)
                                            ->count();

        $recent_investors = UserInvestment::where('is_paid', 1)
                                                ->orderBy('id', 'desc')
                                                ->limit(5)
                                                ->get();

        return view('v1.admin.authenticated.index', 
                    ['user_investment' => $user_investment, 'listed_properties' => $listed_properties, 
                    'active_investment' => $active_investment, 'completed_investment' => $completed_investment, 
                    'rented_properties' => $rented_properties, 'recent_investors' => $recent_investors], 
                    compact('chart1'));
    }
}
