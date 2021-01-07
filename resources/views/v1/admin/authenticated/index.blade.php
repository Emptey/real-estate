@extends('v1.master.admin')

@section('title', 'Dashboard')

@section('content')
    <div class="row">
        <div class="col-md-12 col-lg-12 col-sm-12  no-padding">
            <h4 class="float-left"> <i class="fa fa-home"></i> Dashboard</h4>
            <a href="#" class="btn btn-light btn-lg float-right">
                Report 
                <i class="fa fa-download"></i>
            </a>
        </div>
    </div>
    
    <div class="row" style="margin-top:1.5%;">
        <div class="col-md-8 col-lg-8 col-sm-12 no-padding-left">
            <div class=" shadow mb-5 rounded" style="padding:1.1%">
                <h3 class="title">
                    Recent investment transactions 
                </h3>
                
                <div>
                    <canvas id="myChart" width="400" height="155"></canvas>
                    
                    <script>
                        var chart_labels = [];
                        var chart_data = [];
                        @foreach($user_investment as $month=> $transaction)
                            chart_labels.push('{!! substr($month, 0, 7) !!}');
                            chart_data.push('{!! $transaction->count() !!}');
                        @endforeach
                        var ctx = document.getElementById('myChart').getContext('2d');
                        var myChart = new Chart(ctx, {
                            type: 'line',
                            data: {
                                labels: chart_labels,
                                datasets: [{
                                    label: 'No of transactions by month',
                                    data: chart_data,
                                    backgroundColor: [
                                        'rgba(255, 99, 132, 0.2)',
                                        'rgba(54, 162, 235, 0.2)',
                                        'rgba(255, 206, 86, 0.2)',
                                        'rgba(75, 192, 192, 0.2)',
                                        'rgba(153, 102, 255, 0.2)',
                                        'rgba(255, 159, 64, 0.2)'
                                    ],
                                
                                }]
                            },
                        
                        });

                    </script>

                </div>
            </div>
        </div>
        
        <div class="col-md-4 col-lg-4 col-sm-12 no-padding">
            <div class="shadow mb-5 rounded medium-div-spacing x5-padding">
                <h3 class="title">
                    Investment overview
                </h3>

                <div style="margin-top:4%">
                    <p class="overview-title"> {!! $listed_properties !!} properties listed</p>
                    <div class="progress" style="box-shadow: -6px -6px 10px rgba(255, 255, 255, 0.8),
                                            6px 6px 10px rgba(0, 0, 0, 0.2);">
                        <div class="progress-bar progress-bar-striped bg-info" role="progressbar" 
                            style="width: 75%" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div>

                <div style="margin-top:7%">
                    <p class="overview-title"> {!! $active_investment !!} active investments</p>
                    <div class="progress" style="box-shadow: -6px -6px 10px rgba(255, 255, 255, 0.8),
                                            6px 6px 10px rgba(0, 0, 0, 0.2);">
                        <div class="progress-bar progress-bar-striped bg-warning" role="progressbar" 
                            style="width: 75%" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div>

                <div style="margin-top: 7%">
                    <p class="overview-title"> {!! $completed_investment !!} completed investment</p>
                    <div class="progress" style="box-shadow: -6px -6px 10px rgba(255, 255, 255, 0.8),
                                                6px 6px 10px rgba(0, 0, 0, 0.2);">
                        <div class="progress-bar progress-bar-striped bg-success" role="progressbar" 
                            style="width: 44%" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div>

                <div style="margin-top: 7%; margin-bottom: 8.5%">
                    <p class="overview-title">{!! $rented_properties !!} rented properties</p>
                    <div class="progress" style="box-shadow: -6px -6px 10px rgba(255, 255, 255, 0.8),
                                            6px 6px 10px rgba(0, 0, 0, 0.2);">
                        <div class="progress-bar progress-bar-striped" role="progressbar" 
                            style="width: 50%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12 col-lg-12 col-sm-12 shadow mb-5 rounded div-space">
            <h3 class="title">
                User registration rate 
            </h3>
            <div>
               
                {!! $chart1->renderHtml() !!}
            </div>
        </div>
    </div>

    <div class="row">
    <div class="col-md-6 col-lg-6 col-sm-12 no-padding-left">
            <div class="shadow mb-5 rounded medium-div-spacing">
                <h3 class="title">
                    Recent investors
                </h3>

                <div class="table-responsive">
                        <table class="table table-stripped table-hover  table-borderless">
                            <tbody>
                                @foreach($recent_investors as $new_investors)
                                    <tr class="border-bottom">
                                        <td>
                                            <p style="margin:1%">
                                                <span class="{!! app('App\Http\Controllers\Helper')::generate_initial_style() !!}"> 
                                                    {!! ucfirst(substr($new_investors->user->full_name, 0, 1)) !!} 
                                                </span>
                                                {!! ucwords($new_investors->user->full_name) !!}
                                            </p>
                                        </td>

                                        <td>
                                            #{!! number_format($new_investors->amount, 2) !!}
                                        </td>

                                        <td>
                                            {!! substr($new_investors->created_at, 0, 10) !!}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-lg-6 col-sm-12 no-padding">
            <div class="shadow mb-5 rounded medium-div-spacing">
               <h3 class="title">
                   Total transactions
                </h3>
            </div>
        </div>
    </div>
@endsection

@section('javascript')
{!! $chart1->renderChartJsLibrary() !!}
{!! $chart1->renderJs() !!}
@endsection