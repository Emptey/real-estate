@extends('v1.master.pdf')

@section('content')

    <div class="table-responsive">
        <div class="table-head text-center">
            <h3>Logo</h3>
            <h5>Address: this is where the address goes, phone: 080xxxxxxxx</h5>
        </div>

        <h4 style="margin-bottom:1%; color: #2774AE">{{ strtoupper($title) }}</h4>
        <table class="table table-stripped">
            <thead>
                <tr class="table-primary">
                    <th>#</th>
                    <th>Account name</th>
                    <th>Account number</th>
                    <th>Bank name</th>
                    <th>Amount</th>
                </tr>
            </thead>
            
            <tbody>
            <?php $count = 1; ?>
                @foreach($sell_offs as $sell_payout)
                    <tr>
                        <td>{{$count}}</td>
                        <td>{!! $sell_payout->user->user_bank->account_name !!}</td>
                        <td>{!! $sell_payout->user->user_bank->account_number !!}</td>
                        <td>{!! $sell_payout->user->user_bank->bank !!}</td>
                        <td>NGN{!! number_format($sell_payout->amount_paid, 2) !!}</td>
                    </tr>
                    <?php $count++; ?>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection