@extends('v1.master.admin')

@section('title', 'investment')

@section('content')
    <div class="row">
        <div class="col-md-12 col-lg-12 col-sm-12  no-padding">
            <div class="row">
                <div class="col-md-6">
                    <h4 class="float-left"> <i class="fa fa-chart-pie"></i> Investment Manager</h4>
                </div>

                <div class="col-md-6 text-right">
                    <a href="{{ route('get-add-investment') }}" class="btn btn-info btn-lg text-dark {{ app('App\Http\Controllers\Helper')->superAdminStatus() }} " style="display:inline-block; margin-right: 1% !important">
                        Investment
                        <i class="fa fa-plus"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="row first-content-row">
        <div class="col-md-12 col-lg-12 col-sm-12 no-padding-left">
            <div class="shadow mb-5 rounded" style="padding: 1.2%">
                <form action="{{ route('search-investment') }}" method="post" style="margin-bottom: 1.7%">
                    @csrf

                    <div class="input-group" style="width:400px;">
                        <input type="text" name="search" class="form-control form-control-lg" id="search" placeholder="search property name" />
                        <button type="submit" class="btn btn-search" style="border-top-right-radius:360px; border-bottom-right-radius:360px">
                            <i class="fa fa-search"></i> 
                        </button>
                    </div>

                        @error('search')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                </form>

                <div class="table-responsive">
                    <table class="table table-stripped table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Slots</th>
                                <th>Avail slots</th>
                                <th>Amount</th>
                                <th class="text-center">Rented</th>
                                <th class="text-center">Filled</th>
                                <th class="text-center">Completed</th>
                                <th class="text-center">Options</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(!is_null($investments))
                                <?php $counter = 1; ?>
                                @foreach($investments as $investment)
                                    <tr>
                                        <td>{{ $counter }}</td>
                                        <td> {!! $investment->property_listing->title !!} </td>
                                        <td> {!! $investment->property_listing->slot !!} </td>
                                        <td> {!! $investment->avail_slot !!} </td>
                                        <td> NGN{!! number_format($investment->amount_per_slot, 2) !!} </td>
                                        <td class="text-center">
                                            @if($investment->property_listing->is_rentable)
                                                {!! $investment->is_rented ? '<i class="fa fa-check-circle text-success"></i>' : '<i class="fa fa-times-circle text-danger"></i>' !!}
                                            @else 
                                                <i class="fa fa-times-circle text-danger disable"></i>
                                            @endif
                                        </td>
                                        <td class="text-center"> {!! $investment->is_filled ? '<i class="fa fa-check-circle text-success"></i>' : '<i class="fa fa-times-circle text-danger"></i>' !!} </td>
                                        <td class="text-center"> {!! $investment->is_complete ? '<i class="fa fa-check-circle text-success"></i>' : '<i class="fa fa-times-circle text-danger"></i>' !!} </td>
                                        <td class="text-center">
                                            <a href="#" class="btn btn-light">View</a>
                                            @if($investment->property_listing->is_rentable)
                                                @if($investment->is_rented)
                                                    <a class="btn btn-danger" href="{{ route('change-investment-rentage-status', \Crypt::encrypt($investment->id)) }}"> Off rentage </a>
                                                @else
                                                    <a class="btn btn-success" href="{{ route('change-investment-rentage-status', \Crypt::encrypt($investment->id)) }}"> On rentage </a>
                                                @endif
                                            @else 
                                                <a class="btn btn-danger disabled" href="#" title="Investment doesn't have rentage feature"> Off rentage </a>
                                            @endif
                                        </td>
                                    </tr>
                                    <?php $counter++; ?>
                                @endforeach
                            @else
                                <tr>
                                    <td class="text-center" colpsan="8">
                                        There are no investments available
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>

                <div class="paginate">
                    @if(!is_null($investments))
                        {{ $investments->links() }}
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection