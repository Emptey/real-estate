<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use LaravelDaily\LaravelCharts\Classes\LaravelChart;  // importing laravel js chart
use App\User;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

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

        // gettting all investment purchase record for chart
        $user_investment = DB::table('user_investments')
                ->where('is_paid', 1)
                ->orderBy('id', 'desc')
                ->get()
                ->groupBy(function($val){
                    return Carbon::parse($val->created_at)->format('Y-m');
                });
                // ->having('is_paid', 1);
    
        $chart1 = new LaravelChart($chart_options);


        return view('v1.admin.authenticated.index', ['user_investment' => $user_investment], compact('chart1'));
    }
}
