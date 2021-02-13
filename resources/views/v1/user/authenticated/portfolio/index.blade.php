@extends('v1.master.user')

@section('title', 'portfolio')

@section('content')
    <div class="row">
        <div class="col-md-4 col-lg-4 col-sm-12">
            <div class="small-box">
                <h2 class="box-title-2 mb-3">
                    Overview
                </h2>
                <canvas id="overview" width="300" height="200"> </canvas> 
            </div>
        </div>
        <div class="col-md-4 col-lg-4 col-sm-12">
            <div class="small-box">
                <h2 class="box-title-2">
                    Sells return
                </h2>

                <h2 class="box-title mt-5 mb-5">
                    @if(!is_null($user_investment))
                        <?php $counter = 0; ?>
                        @foreach($user_investment as $user_investments)
                            <?php $counter += $user_investments->investment->property_listing->sell_off_profit_percent; ?>
                        @endforeach
                        <h2 class="box-title mt-5 mb-5">{{ $counter }}%</h2>
                    @else
                        <h2 class="box-title mt-5 mb-5">0%</h2>
                    @endif
                </h2>
            </div>
        </div>
        <div class="col-md-4 col-lg-4 col-sm-12">
            <div class="small-box">
                <h2 class="box-title-2">
                    Rentage return
                </h2>
                @if(!is_null($user_investment))
                    <?php $counter = 0; ?>
                    @foreach($user_investment as $user_investments)
                        <?php $counter += $user_investments->investment->property_listing->rentage_profit_percent; ?>
                    @endforeach
                    <h2 class="box-title mt-5 mb-5">{{ $counter }}%</h2>
                @else
                    <h2 class="box-title mt-5 mb-5">0%</h2>
                @endif
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12 col-lg-12 col-sm-12">
            <div class="small-box">
                <form action="{{ route('post-user-portfolio') }}" method="post">
                    @csrf
                    <div class="form-group">
                        <div class="portfolio-search-box">
                            <input type="text" name="search" id="search" placeholder="Search" autocomplete="off" required="yes" />
                            <button type="submit" class="btn-transparent">
                                <span class="iconify search-icon" data-icon="ant-design:search-outlined" data-inline="false"></span>
                            </button>
                        </div>
                    </div>
                </form>

                <div class="table-responsive mt-5">
                    <table class="table table-stripped table-hover">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th class="text-center">Slot</th>
                                <th class="text-center">Return</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Options</th>
                            </tr>
                        </thead>

                        <tbody>
                            @if(!is_null($all_user_investment))
                                @foreach($all_user_investment as $investment)
                                <tr class="text-left">
                                    <td>{{ ucfirst($investment->investment->property_listing->title) }}</td>
                                    <td class="text-center">{{ $investment->purchased_slot }}</td>
                                    <td class="text-center">{{ $investment->investment->property_listing->sell_off_profit_percent }}%</td>
                                    <td class="text-center">
                                       <span class="@if(app('App\Http\Controllers\Helper')->get_user_investment_status($investment) == 'inactive') 
                                           text-danger @elseif(app('App\Http\Controllers\Helper')->get_user_investment_status($investment) == 'active')
                                           text-warning @elseif(app('App\Http\Controllers\Helper')->get_user_investment_status($investment) == 'completed') text-success @endif">
                                           {{ app('App\Http\Controllers\Helper')->get_user_investment_status($investment) }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('get-user-portfolio-investment', \Crypt::encrypt($investment->id)) }}">
                                            <span class="iconify icon" data-icon="fluent:clipboard-search-24-regular" data-inline="false"></span>
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td class="text-danger text-center" colspan="5">No investment record.</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
                @if(!is_null($all_user_investment))
                    {{ $all_user_investment->links() }}
                @endif
            </div>
        </div>
    </div>
@endsection