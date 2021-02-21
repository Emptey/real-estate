@extends('v1.master.user')

@section('title', 'dashboard')

@section('content')
    <div class="row">
        <div class="col-md-8 col-lg-8 col-sm-12 no-padding">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-6 col-lg-6 col-sm-12">
                        <div class="small-box">
                            <h2 class="box-title-2">Investment</h2>
                            <h2 class="box-title">
                                {{ !is_null($user_investment) ? $user_investment->count() : '0' }}
                            </h2>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-6 col-sm-12">
                        <div class="small-box">
                            <h2 class="box-title-2">Sell return</h2>
                            
                            @if(!is_null($user_investment))
                                <?php $counter = 0; ?>
                                @foreach($user_investment as $user_investments)
                                    <?php $counter += $user_investments->investment->property_listing->sell_off_profit_percent; ?>
                                @endforeach
                                <h2 class="box-title">{{ $counter }}%</h2>
                            @else
                                <h2 class="box-title">0%</h2>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-lg-4 col-sm-12">
            <div class="small-box">
                <h2 class="box-title-2">Rentage return</h2>
                @if(!is_null($user_investment))
                    <?php $counter = 0; ?>
                    @foreach($user_investment as $user_investments)
                        <?php $counter += $user_investments->investment->property_listing->rentage_profit_percent; ?>
                    @endforeach
                    <h2 class="box-title">{{ $counter }}%</h2>
                @else
                    <h2 class="box-title">0%</h2>
                @endif
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8 col-lg-8 col-sm-12">
            <div class="small-box">
                <h2 class="box-title-2">Investment rate</h2>
                <canvas id="myChart" width="300" height="100"> </canvas> 

                <!-- <script>
                    
                </script> -->
            </div>
        </div>
        <div class="col-md-4 col-lg-4 col-sm-12">
            <div class="small-box fit-parent">
                <h2 class="box-title-2">
                    Investment status
                </h2>

                <div class="mt-4">
                    <canvas id="status" width="300" height="200"> </canvas> 
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12 col-lg-12 col-sm-12">
            <div class="small-box">
                <h2 class="box-title-2">Rentage return rate</h2>
                <canvas id="myChart2" width="300" height="100"> </canvas>
                <input type="hidden" name="active_id" id="active_id" value="{{ \Crypt::encrypt(\Auth::user()->id) }}"/>
                <p class="text-center text-danger" id="warning"></p>
            </div>
        </div>
    </div>
@endsection