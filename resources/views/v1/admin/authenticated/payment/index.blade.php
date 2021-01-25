@extends('v1.master.admin')

@section('title', 'payment')

@section('content')
    <div class="row">
        <div class="col-md-12 col-lg-12 col-sm-12  no-padding">
            <div class="row">
                <div class="col-md-6">
                    <h4> <i class="fa fa-coins"></i> 
                        Payment Manager
                    </h4>
                </div>

                <div class="col-md-6 text-right">
                    <div id="rent-list">
                        <a href="/authenticator/authorized/payment/action/pay/rent/list/pdf" class="btn btn-warning btn-lg">Payment list <i class="fa fa-download"></i></a>
                    </div>
                    <div id="sell-off-list" class="off">
                        <a href="/authenticator/authorized/payment/action/pay/sell-off/list/pdf/" class="btn btn-warning btn-lg">Payment list <i class="fa fa-download"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row first-content-row">
        <div class="col-md-12 col-lg-12 col-sm-12 no-padding">
            <div class="shadow mb-5 rounded" style="padding: 1.2%">
                <h4></h4>
                <ul class="nav nav-tabs" id="myTab" role="tablist" style="margin-top: 1.5%">
                    <li class="nav-item" id="rent-button">
                        <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Rent payout</a>
                    </li>
                    <li class="nav-item" id="sell-off-button">
                        <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Sell-off payout</a>
                    </li>
                </ul>

                <div class="tab-content" id="myTabContent" style="margin-top: 3%">
                    <!-- Rent payment div -->
                    <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                        <form action="{{ route('action-pay-all') }}" class="get">
                            @csrf
                            <div class="form-group" style="margin:2% 0 1.5%; width:40%">
                                <select name="action" id="action" class="form-control form-control-lg">
                                    <option value="">-option-</option>
                                    <option value="0">Pay all</option>
                                </select>
                                @error('action')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                           <div class="from-group" style="margin-bottom:1.5%">
                                <button class="btn btn-search btn-lg">
                                    Proceed <i class="fa fa-check-circle"></i>
                                </button>
                           </div>
                        </form>

                        <!-- Email modal -->
                       <!-- Button trigger modal -->
                        <!-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#staticBackdrop">
                        Launch static backdrop modal
                        </button> -->

                        <!-- Modal -->
                        <!-- <div class="modal fade" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="staticBackdropLabel">Modal title</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                ...
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-primary">Understood</button>
                            </div>
                            </div>
                        </div>
                        </div>
                        end email modal -->

                        <div class="table-responsive">
                            <table class="table table-stripped table-hover">
                                <thead>
                                    <th>#</th>
                                    <th>Account number</th>
                                    <th>Account number</th>
                                    <th>Bank name</th>
                                    <th>Amount</th>
                                    <th class="text-center">Options</th>
                                </thead>

                                <tbody>
                                    @if(!is_null($rent_payments))
                                        <?php $count = 1; ?>
                                        @foreach($rent_payments as $rent_payment)
                                            <tr class="{{ $count % 2 == 0? 'table-success' : '' }}">
                                                <td>{{ $count }}</td>
                                                <td>{{ $rent_payment->user->user_bank->account_name }}</td>
                                                <td>{{ $rent_payment->user->user_bank->account_number }}</td>
                                                <td>{{ $rent_payment->user->user_bank->bank }}</td>
                                                <td>NGN{{ number_format($rent_payment->amount_paid, 2) }}</td>
                                                <td class="text-center">
                                                    <!-- <button type="button" class="btn btn-light btn-lg" data-toggle="modal" data-target="#exampleModalLong">
                                                        Send mail <i class="far fa-envelope"></i>
                                                    </button> -->
                                                    <a href="{{ route('pay-user', \Crypt::encrypt($rent_payment->user_id)) }}" 
                                                        class="btn btn-light btn-lg">
                                                            Paid 
                                                            <i class="fa fa-check-circle"></i> 
                                                    </a>
                                                </td>
                                            </tr>
                                            <?php $count += 1; ?>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td class="text-center text-danger" colspan="6">There are no rent payouts to be made.</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- investmet payment div -->
                    <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                        
                        <form action="{{ route('pay-all-users-sell-off') }}" class="get">
                            @csrf
                            <div class="form-group" style="margin:2% 0 1.5%; width:40%">
                                <select name="action" id="action" class="form-control form-control-lg">
                                    <option value="">-option-</option>
                                    <option value="0">Pay all</option>
                                </select>
                                @error('action')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                           <div class="from-group" style="margin-bottom:1.5%">
                                <button class="btn btn-search btn-lg">
                                    Proceed <i class="fa fa-check-circle"></i>
                                </button>
                           </div>
                        </form>

                        <div class="table-responsive">
                            <table class="table table-stripped table-hover">
                                <thead>
                                    <th>#</th>
                                    <th>Account name</th>
                                    <th>Account number</th>
                                    <th>Bank name</th>
                                    <th>Amount</th>
                                    <th class="text-center">Options</th>
                                </thead>

                                <tbody>
                                    @if(!is_null($sell_off_payments))
                                        <?php $count = 1; ?>
                                        @foreach($sell_off_payments as $sell_off_payment)
                                            <tr class="{{ $count % 2 == 0? 'table-success' : '' }}">
                                                <td>{{ $count }}</td>
                                                <td> {!! $sell_off_payment->user->user_bank->account_name !!} </td>
                                                <td>{!! $sell_off_payment->user->user_bank->account_number !!}</td>
                                                <td> {!! $sell_off_payment->user->user_bank->bank !!} </td>
                                                <td> NGN{!! number_format($sell_off_payment->amount_paid, 2) !!} </td>
                                                <td class="text-center">
                                                    <a href="{{ route('pay-user-sell-off', \Crypt::encrypt($sell_off_payment->user_id)) }}" class="btn btn-light">Paid <i class="fa fa-check-circle"></i> </a>
                                                </td>
                                            </tr>
                                        <?php $count+= 1; ?>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td class="text-center text-danger" colspan="6">There are no sell off payments to be made.</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>

                        @if(!is_null($sell_off_payments))
                            {!! $sell_off_payments->links() !!}
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection