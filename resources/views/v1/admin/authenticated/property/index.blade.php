@extends('v1.master.admin')

@section('title', 'property listing')

@section('content')
    <div class="row">
        <div class="col-md-12 col-lg-12 col-sm-12  no-padding">
            <div class="row">
                <div class="col-md-6">
                    <h4 class="float-left"> <i class="fa fa-building"></i> Property listing</h4>
                </div>

                <div class="col-md-6 text-right">
                    <a href="/authenticator/authorized/user/generate/pdf" class="btn btn-warning btn-lg text-dark" style="display:inline-block; margin-left: 5%">
                        Export
                        <i class="fa fa-file-pdf"></i>
                    </a>

                    <a href="{{ route('get-add-property') }}" class="btn btn-info btn-lg text-dark {{ app('App\Http\Controllers\Helper')->superAdminStatus() }} " style="display:inline-block; margin-right: 1% !important">
                        Property
                        <i class="fa fa-plus"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="row first-content-row">
        <div class="col-md-8 col-lg-8 col-sm-12 no-padding-left">
            <div class="shadow mb-5 rounded" style="padding: 1.2%">
                <h3 class="title">
                    Property listing rate
                </h3>
                <div>
                    <canvas id="myChart" width="400" height="155"></canvas>

                    <script>
                        var chart_data = [];
                        var chart_labels = [];
                        @foreach($chart_property as $month=>$chart_properties)
                            chart_labels.push('{!! $month !!}');
                            chart_data.push('{!! $chart_properties->count() !!}');
                        @endforeach
                        var ctx = document.getElementById('myChart').getContext('2d');
                        var myBarChart = new Chart(ctx, {
                            type: 'bar',
                            data: {
                                labels: chart_labels,
                                datasets: [{
                                    label: 'Listing rate',
                                    data: chart_data,
                                    backgroundColor: [
                                        'rgba(255, 99, 132, 0.2)',
                                        'rgba(54, 162, 235, 0.2)',
                                        'rgba(255, 206, 86, 0.2)',
                                        'rgba(75, 192, 192, 0.2)',
                                        'rgba(153, 102, 255, 0.2)',
                                        'rgba(255, 159, 64, 0.2)',
                                    ],
                                    borderColor: [
                                        'rgba(255, 99, 132, 0.2)',
                                        'rgba(54, 162, 235, 0.2)',
                                        'rgba(255, 206, 86, 0.2)',
                                        'rgba(75, 192, 192, 0.2)',
                                        'rgba(153, 102, 255, 0.2)',
                                        'rgba(255, 159, 64, 0.2)',
                                    ],
                                }],
                            },
                        });
                    </script>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-lg-4 col-sm-12 no-padding">
            <div class="shadow mb-5 rounded" style="padding:3%">
                <h3 class="title">
                    Recently added properties
                </h3>

                @if($properties->count() > 0)
                    @foreach($properties as $property)
                        <div class="text-sendary" style="margin-top:2%">
                            <p class="text-secondary">
                                <i class="fa fa-plus text-success" style="margin-right: 1.5%"></i>
                                {!! $property->title  !!}
                            </p>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12 col-lg-12 col-sm-12 no-padding">
            <div class="shadow mb-5 rounded big-wrapper">
                <form action="{{ route('search-property') }}" method="post" style="margin-bottom: 1.7%">
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
                                <th>Title</th>
                                <th>Address</th>
                                <th>Description</th>
                                <th>Cost</th>
                                <th class="text-center">Rentage</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Options</th>
                            </tr>
                        </thead>

                        <tbody>
                            @if($table_properties->count() > 0)
                                <?php $count = 1; ?>
                                @foreach($table_properties as $table_property)
                                    <tr>
                                        <td>{{ $count }}</td>
                                        <td>{!! strtolower($table_property->title) !!}</td>
                                        <td>{!! strtolower($table_property->address) !!}</td>
                                        <td>{!! strtolower($table_property->description) !!}</td>
                                        <td class="text-success">NGN{!! number_format($table_property->purchase_amount) !!}</td>
                                        <td class="text-center"> 
                                            <i class="fa fa-{!!  $table_property->is_rentable ? 'check-circle text-success' : 'times-circle text-danger' !!}"></i>
                                        </td>
                                        <td class="text-center">
                                            {!! app('App\Http\Controllers\Helper')->getStatus($table_property) !!} 
                                            </td>
                                        <td class="text-center">
                                            <a href="{{ route('view-property', \Crypt::encrypt($table_property->id)) }}" class="btn btn-light">view</a>
                                            <a href="{{ route('change-property-status', \Crypt::encrypt($table_property->id)) }}" 
                                                class="{!! app('App\Http\Controllers\Helper')->getButton($table_property) !!} text-light">
                                                    {!! $table_property->is_active ? 'disable' : 'enable' !!}
                                            </a>
                                        </td>
                                    </tr>
                                    <?php $count++; ?>
                                @endforeach
                            @else
                                <tr>
                                    <td class="text-center text-danger" colspan="8">
                                        There no listed properties.
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
                <div class="paginate">
                    {!! $table_properties->links() !!}
                </div>
            </div>
        </div>
    </div>
@endsection