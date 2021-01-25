@extends('v1.master.admin')

@section('title', 'view property')

@section('content')
    <div class="row">
        <div class="col-md-12 col-lg-12 col-sm-12  no-padding">
            <div class="row">
                <div class="col-md-6">
                    <h4 class="float-left"> <i class="fa fa-building"></i> Property listing</h4>
                </div>

                <div class="col-md-6 text-right">

                    <a href="{{ route('get-update-property-setp-one', \Crypt::encrypt($property->id)) }}" class="btn btn-info btn-lg text-dark {{ app('App\Http\Controllers\Helper')->superAdminStatus() }}" style="display:inline-block; margin-right: 1% !important">
                        Edit
                        <i class="fa fa-edit"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="row first-content-row">
        <div class="col-md-12 col-lg-12 col-sm-12 no-padding">
            <div class="shadow mb-5 rounded big-wrapper" style="padding: 3%">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-7 col-lg-7 col-sm-12" style="padding-left: 2.8%; margin-bottom: 0.5%">
                            <!-- <h4 style="text-decoration:dotted; color: #2774AE;"> {!! ucfirst($property->title) !!} </h4> -->
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-5 col-lg-5 col-sm-12">
                            <div class="container-fluid">

                                <div class="row">
                                    <div class="col-md-12 col-lg-12 col-sm-12">
                                        
                                        <img src="{!! Storage::url('public/images/'.$property->property_images->pluck('front_view')->first()) !!}" alt=""
                                            class="img img-responsive img-thumbnail" id="main-img" style="height: 400px !important" />

                                            <div style="margin-top: 4%; background-color: rgba(200, 200, 200, 0.4); padding: 2% 1% 2%">
                                                <img src="{!! Storage::url('public/images/'.$property->property_images->pluck('side_view')->first()) !!}" alt=""
                                                    class="img img-thumbnail img-click" style="display:inline; height: 200px; margin-right: 0.14%" id="side_image"/>

                                                <img src="{!! Storage::url('public/images/'.$property->property_images->pluck('back_view')->first()) !!}" alt=""
                                                    class="img img-thumbnail img-click" style="display: inline; height: 200px " id="back_image" />
                                            </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-7 col-lg-7 col-sm-12 no-padding">

                            <div>
                            <h4 class="font-weight-bold"  style="color: #2774AE;"> {!! strtoupper($property->title) !!} </h4>    

                               <p style="border-bottom: 1px solid rgba(200, 200, 200, 0.4); border-top: 1px solid rgba(200, 200, 200, 0.4); padding: 1.1% 0 1.1%">
                                    <span class="font-weight-bold">
                                        <fa class="fa fa-poll" style="color: #2774AE;"></fa>
                                        Cost: 
                                    </span>
                                    NGN{!! number_format($property->purchase_amount, 2) !!}
                               </p>
                            </div>

                            <div>
                                <p style="border-bottom: 1px solid rgba(200, 200, 200, 0.4); padding-bottom: 1%">
                                    <span class="font-weight-bold">
                                        <i class="fa fa-poll-h" style="color: #2774AE;"></i>
                                        Mgnt fee: 
                                    </span>
                                    NGN{!! number_format($property->mngt_fee, 2) !!}
                                </p>
                            </div>

                            <div>
                                <p style="border-bottom: 1px solid rgba(200, 200, 200, 0.4); padding-bottom: 1%">
                                    <span class="font-weight-bold">
                                        <i class="fa fa-coins" style="color: #2774AE;"></i>
                                        Sell-off price: 
                                    </span>
                                    NGN{!! number_format($property->sell_off_price, 2) !!}
                                </p>
                            </div>

                            <div>
                                <p style="border-bottom: 1px solid rgba(200, 200, 200, 0.4); padding-bottom: 1%">
                                    <span class="font-weight-bold">
                                        <i class="fa fa-chart-pie" style="color: #2774AE;"></i>
                                        Sell-off roi:
                                    </span>
                                    {!! $property->sell_off_profit_percent !!}%
                                </p>
                            </div>

                            <div>
                                <p style="border-bottom: 1px solid rgba(200, 200, 200, 0.4); padding-bottom: 1%">
                                    <span class="font-weight-bold">
                                        <i class="fa fa-money" style="color: #2774AE;"></i>
                                        Rentage price:
                                    </span>
                                    {!! $property->rentage_price !!}
                                </p>
                            </div>

                            <div>
                                <p style="border-bottom: 1px solid rgba(200, 200, 200, 0.4); padding-bottom: 1%">
                                    <span class="font-weight-bold">
                                        <i class="fa fa-chart-bar" style="color: #2774AE;"></i>
                                        Rentage roi:
                                    </span>
                                    {!! $property->rentage_profit_percent !!}%
                                </p>
                            </div>

                            <div>
                                <p style="border-bottom: 1px solid rgba(200, 200, 200, 0.4); padding-bottom: 1%">
                                    <span class="font-weight-bold">
                                        <i class="fa fa-plus-square" style="color: #2774AE;"></i>
                                        Slot: 
                                    </span>
                                    {!! $property->slot !!}

                                </p>

                                <p style="border-bottom: 1px solid rgba(200, 200, 200, 0.4); padding-bottom: 1%">
                                    <span class="font-weight-bold">
                                        <i class="fa fa-clock" style="color: #2774AE;"></i>
                                        Duration: 
                                    </span>
                                    {!! $property->duration !!}
                                </p>
                            </div>

                            <div>
                                <h5 class="font-weight-bold">
                                    <i class="fas fa-map-marker-alt" style="color: #2774AE;"></i> Address
                                </h5>
                                <p>
                                    {!! $property->address !!}
                                </p>
                            </div>

                            <div>
                                <p>
                                    <span class="font-weight-bold" style="display: block">
                                        <i class="fa fa-edit" style="color: #2774AE;"></i> Description
                                    </span>

                                    {!! ucfirst($property->description) !!}
                                </p>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection