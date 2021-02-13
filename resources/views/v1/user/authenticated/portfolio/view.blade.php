@extends('v1.master.user')

@section('title', 'view investment')

@section('content')
    <div class="row">
        <div class="col-md-12 col-lg-12 col-sm-12">
            <div class="small-box">
                <div class="container-fluid">
                    <div class="row  pb-5">
                        <div class="col-md-12 col-lg-12 col-sm-12 text-left">
                            <h2 class="portfolio-title">{{ ucfirst($user_investment->investment->property_listing->title) }}</h2>
                        </div>
                        <div class="col-md-5 col-lg-5 col-sm-12 text-left no-padding">
                            
                            <img src="{{ Storage::url('public/images/'.$user_investment->investment->property_listing->property_images->pluck('front_view')->first()) }}" alt="" class="img img-responsive protfolio-img" title="property_img" alt="property image" />
                        </div>
                        <div class="col-md-7 col-lg-7 col-sm-12 text-left">
                            <p class="portfolio-text">
                                <span class=""><span class="iconify" data-icon="fluent:bed-24-regular" data-inline="false"></span> {{ $user_investment->investment->property_listing->bedroom }} </span>
                                <span class="portfolio-detail-icon"><span class="iconify" data-icon="cil:shower" data-inline="false"></span> {{ $user_investment->investment->property_listing->bathroom }}</span>
                                <span class="portfolio-detail-icon"><span class="iconify" data-icon="uil:toilet-paper" data-inline="false"></span> {{ $user_investment->investment->property_listing->toilet }} </span>
                            </p>
                            <p class="portfolio-text">
                                Duration: {{ $user_investment->investment->property_listing->duration }} years
                            </p>

                            <p class="portfolio-text">
                                Rentage: {!! $user_investment->investment->property_listing->is_rentable ? '<span class="text-success">on</span>' : '<span class="text-danger">off</span>' !!}
                            </p>

                            <p class="portfolio-text">
                                Purchased slot: {{ $user_investment->purchased_slot }} slot(s)
                            </p>

                            <p class="portfolio-text">
                                Amount: NGN{{ number_format($user_investment->amount, 2) }}
                            </p>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12 col-lg-12 col-sm-12 text-left">
                            <h2 class="box-title-2 mb-5 mt-5">Transactions</h2>
                            <div class="table-responsive">
                                <table class="table table-hover table-stripped">
                                    <thead>
                                        <tr>
                                            <th>Amount</th>
                                            <th class="text-center">Status</th>
                                            <th class="text-center">Return</th>
                                            <th class="text-center">Date</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                       @if(!is_null($transactions))
                                            @foreach($transactions as $transaction)
                                            <tr>
                                                <td>NGN{{ number_format($transaction->amount_paid, 2) }}</td>
                                                <td class="text-center">{!! $transaction->is_paid ? '<span class="text-center text-success">Paid</span>' : '<span class="text-center text-danger">Not paid</span>' !!}</td>
                                                <td class="text-center">
                                                    {{ $transaction->investment->property_listing->rentage_profit_percent }}%
                                                </td>
                                                <td class="text-center">{{ substr($transaction->created_at, 0, 10) }}</td>
                                            </tr>
                                            @endforeach
                                       @else
                                            <tr>
                                                <td class="text-center text-danger" colspan="4">No payouts made yet.</td>
                                            </tr>
                                       @endif
                                    </tbody>
                                </table>
                            </div>

                            @if(!is_null($transactions))
                                {{ $transactions->links() }}
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection