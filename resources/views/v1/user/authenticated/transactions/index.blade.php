@extends('v1.master.user')

@section('title', 'transactions')

@section('content')
    <div class="row">
        <div class="col-md-4 col-lg-4 col-sm-12">
            <div class="small-box">
                <h2 class="box-title-2">Incoming</h2>
                
                <h2 class="box-title text-success">{{ $incoming }}</h2>
            </div>
        </div>

        <div class="col-md-4 col-lg-4 col-sm-12">
            <div class="small-box sibling">
                <h2 class="box-title-2">Outgoing</h2>
                <h2 class="box-title text-warning">{{ $outgoing }}</h2>
            </div>
        </div>


        <div class="col-md-4 col-lg-4 col-sm-12">
            <div class="small-box sibling">
                <h2 class="box-title-2">
                    Failed
                </h2>
                <h2 class="box-title text-danger">{{ $failed_transactions }}</h2>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12 col-lg-12 col-sm-12">
            <div class="small-box">
                <form action="{{ route('search-user-transaction') }}" method="post">
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
                                <td class="text-left">#</td>
                                <th>Name</th>
                                <th class="text-center">Slot</th>
                                <th class="text-center">Sell off return</th>
                                <th class="text-center">Payment</th>
                                <th class="text-center">Date</th>
                            </tr>
                        </thead>

                        <tbody>
                           @if(!is_null($transactions))
                            <?php $counter = 1; ?>
                                @foreach($transactions as $transaction)
                                    <tr>
                                        <td>{{ $counter }}</td>
                                        <td>{{ ucfirst($transaction->investment->property_listing->title) }}</td>
                                        <td class="text-center"> {{ $transaction->purchased_slot }} </td>
                                        <td class="text-center">{{ $transaction->investment->property_listing->sell_off_profit_percent }}%</td>
                                        <td class="text-center"> {!! $transaction->is_paid ? '<span class="text-success">Successful</span>' : '<span class="text-danger">Failed</span>' !!} </td>
                                        <td class="text-center">{{ substr($transaction->created_at, 0, 10) }}</td>
                                    </tr>
                                    <?php $counter +=1; ?>
                                @endforeach
                           @else
                                <tr>
                                    <td class="text-center text-danger" colspan="5">There are no transaction records available.</td>
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
@endsection