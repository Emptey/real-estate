@extends('v1.master.admin')

@section('title', 'view investment')

@section('content')
    <div class="row">
        <div class="col-md-12 col-lg-12 col-sm-12  no-padding">
            <div class="row">
                <div class="col-md-6">
                    <h4> <i class="fa fa-chart-pie"></i> 
                        Investment Manager
                    </h4>
                </div>

                <div class="col-md-6 text-right">
                    <a href="{{ route('get-admin-investment') }}" class="btn btn-danger btn-lg text-dark" 
                        style="display:inline-block; margin-right: 1% !important">
                            Cancel
                            <i class="fa fa-times"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="row first-content-row">
        <div class="col-md-12 col-lg-12 col-sm-12 no-padding">
            <div class="shadow mb-5 rounded" style="padding: 1.2%">
                <div class="container-fluid">
                    <div class="row" style="padding: 1.2%">
                        <div class="col-md-4 col-lg-4 col-sm-12 no-padding">
                           <img src="{!! Storage::url('public/images/'.$investment->property_listing->property_images->pluck('front_view')->first() ) !!}" 
                            alt="front_view" style="height: 400px;" class="img img-responsive img-thumbnail" />
                        </div>
                        <div class="col-md-7 col-lg-7 col-sm-12">
                            <h3 class="font-weight-bold">
                                {!! strtoupper($investment->property_listing->title) !!}
                            </h3>
                            <p style="margin-top:1.5%; border-bottom: 1px solid rgba(200, 200, 200, 0.4); padding: 1.1% 0% 1.1%;  border-top: 1px solid rgba(200, 200, 200, 0.4)">
                                <span class="font-weight-bold">Avail slot(s):</span> {!! $investment->avail_slot !!} of {!! $investment->property_listing->slot !!}
                            </p>

                            <p style="margin-top:1.5%; border-bottom: 1px solid rgba(200, 200, 200, 0.4); padding-bottom: 1.1%">
                                <span class="font-weight-bold">Amount/per slot:</span> NGN{!! number_format($investment->amount_per_slot, 2) !!}
                            </p>

                            <p style="margin-top:1.5%; border-bottom: 1px solid rgba(200, 200, 200, 0.4); padding-bottom: 1.1%">
                                <span class="font-weight-bold">First rent payout:</span> {!! !is_null($investment->first_rent_payment_date) ? $investment->first_rent_payment_date : '<span class="text-danger">unavailable</span>' !!}
                            </p>

                            <p style="margin-top:1.5%; border-bottom: 1px solid rgba(200, 200, 200, 0.4); padding-bottom: 1.1%">
                                <span class="font-weight-bold">Next rent payout:</span> {!! !is_null($investment->next_rent_payment_date) ? $investment->next_rent_payment_date : '<span class="text-danger">unavailable</span>' !!}
                            </p>

                            <p style="margin-top:1.5%; border-bottom: 1px solid rgba(200, 200, 200, 0.4); padding-bottom: 1.1%">
                                <span class="font-weight-bold">Last rent payout:</span> {!! !is_null($investment->last_rent_payment_date) ? $investment->last_rent_payment_date : '<span class="text-danger">unavailable</span>' !!}
                            </p>

                            <p style="margin-top:1.5%; border-bottom: 1px solid rgba(200, 200, 200, 0.4); padding-bottom: 1.1%">
                                <span class="font-weight-bold">Sell off payment date:</span> {!! !is_null($investment->sell_off_payment_date) ? $investment->sell_off_payment_date : '<span class="text-danger">unavailable</span>' !!}
                            </p>

                            <p style="margin-top:1.5%">
                                <span class="font-weight-bold">Investment expiry date:</span> {!! !is_null($investment->expiry_date) ? $investment->expiry_date : '<span class="text-danger">unavailable</span>' !!}
                            </p>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    
    <div class="row">
        <div class="col-md-12 col-lg-12 col-sm-12 no-padding">
            <div class="shadow mb-5 rounded" style="padding: 1.2%">
                <h4 style="margin: 1% 0 1%">Investors list</h4>
                <div class="table-resposnive">
                    <table class="table table-stripped table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Receipt</th>
                                <th>Slot</th>
                                <th class="text-center">Date</th>
                            </tr>
                        </thead>

                        <tbody>
                            @if(!is_null($user_investment))
                                <?php $count = 1; ?>
                                @foreach($user_investment as $user_investments)
                                    <tr>
                                        <td>{!! $count !!}</td>
                                        <td>{!! $user_investments->user->full_name !!}</td>
                                        <td>{!! $user_investments->user->email !!}</td>
                                        <td>{!! $user_investments->receipt_id !!}</td>
                                        <td>{!! $user_investments->purchased_slot !!}</td>
                                        <td class="text-center">{!! substr($user_investments->created_at, 0, 10) !!}</td>
                                    </tr>
                                    <?php $count+=1; ?>
                                @endforeach
                            @else
                                <tr>
                                    <td class="text-center text-danger" colspan="5">No one has invested in this property yet.</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>

                @if(!is_null($user_investment))
                    {{ $user_investment->links() }}
                @endif
            </div>
        </div>
    </div>
@endsection