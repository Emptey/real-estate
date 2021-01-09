@extends('v1.master.admin')

@section('title', 'view info')

@section('content')
    <div class="row">
        <div class="col-md-12 col-lg-12 col-sm-12  no-padding">
            <div class="row">
                <div class="col-md-6">
                    <h4 class="float-left"> <i class="fa fa-users"></i> User Management</h4>
                </div>

                <div class="col-md-6 text-right">
                    <a href="/authenticator/authorized/user/generate/pdf" class="btn btn-warning btn-lg text-dark" style="display:inline-block; margin-left: 5%">
                        Export
                        <i class="fa fa-file-pdf"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="row first-content-row">
        <div class="col-md-7 col-lg-7 col-sm-12 no-padding-left">
            <div class="shadow mb-5 rounded medium-div-spacing">
                <h3 class="title">
                    Basic information
                </h3>

                <div class="table-responsive" style="margin:0">
                    <table class="table table-borderless">
                        <tr>
                            <td class="text-secondary" style="padding: 2% 0 4%">
                                <span class="font-weight-bold">Name:</span> {!! ucwords($user->full_name) !!}
                            </td>
                            <td class="text-secondary" style="padding: 2% 0 4%">
                                <span class="font-weight-bold">Email:</span> {!! $user->email !!}
                            </td>
                        </tr>

                        <tr>
                            <td class="text-secondary" style="padding: 0 0 4%">
                                <span class="font-weight-bold">Gender:</span> {!! ucfirst($user->gender->gender) !!}
                            </td>
                            <td class="text-secondary" style="padding: 0 0 4%">
                                <span class="font-weight-bold">Country: </span>{!! ucfirst($user->country != ''? $user->country : '<span class="text-danger">unavailable</span>') !!}
                            </td>
                        </tr>

                        <tr>
                            <td class="text-secondary" style="padding: 0 0 4%"> 
                                <span class="font-weight-bold">Joined:</span> {!! app('App\Http\Controllers\Helper')::justDate($user->created_at) !!}
                            </td>
                            <td class="text-secondary" style="padding: 0 0 4%"> 
                                <span class="font-weight-bold">Last seen:</span> {!! $user->updated_at !!}
                            </td>
                        </tr>

                        <tr>
                            <td class="text-secondary" style="padding: 0 0 1.5%"> 
                                <span class="font-weight-bold">Status:</span> {!! $user->is_active? '<span class="text-success">active</span>' : '<span class="text-danger">inactive</span>' !!}
                                {!! app('App\Http\Controllers\Helper')->getStatus($user) !!}  
                            </td>
                        </tr>
                    </table>
                </div>

                <div class="text-left">
                    <a href="{{ route('change-user-status', \Crypt::encrypt($user->id)) }}" class="btn {{ app('App\Http\Controllers\Helper')->getButton($user) }} btn-lg"> {!! $user->is_active ? 'Disable' : 'Enable' !!} <i class="fa fa-check-circle"></i> </a>
                </div>
            </div>
        </div>

        <div class="col-md-5 col-lg-5 col-sm-12 no-padding">
            <div class="shadow mb-5 rounded medium-div-spacing">
                <h3 class="title">
                    Recent activity
                </h3>

                <div style="margin-top: 3%">
                    @if($user_activities->count() > 0)
                        @foreach($user_activities as $user_activity)
                            <div class="text-left text-secondary table-hover">
                                <p> <i class="fa fa-plus text-success" style="margin-right: 1.5%"></i> {!! $user_activity->activity!!}</p>
                            </div>
                        @endforeach
                    @else
                    <div class="text-danger">
                        <p>No activities yet.</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>

    </div>

    <div class="row">
        <div class="col-md-12 col-lg-12 col-sm-12 shadow mb-5 rounded div-space">
            <h3 class="title">Portfolio</h3>
            <ul class="nav nav-tabs" id="myTab" role="tablist" style="margin-top: 1.5%">
                <li class="nav-item">
                    <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Investment</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Rent payment</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false">Sell-off payment</a>
                </li>
            </ul>
            <div class="tab-content" id="myTabContent" style="margin-top: 1.5%">
                <!-- invesment div -->
                <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                    <div class="table-responsive">
                        <table class="table table-stripped table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th class="text-center">Purchased slot</th>
                                    <th>Amount</th>
                                    <th>Receipt</th>
                                    <th class="text-center">Payment status</th>
                                    <th class="text-center">Date</th>
                                </tr>
                            </thead>

                            <tbody>
                                @if($user->user_investment()->count() > 0)
                                    <?php $count = 1; ?>
                                    @foreach($user->user_investment as $user_investment)
                                        <tr>
                                            <td>{!! $count !!}</td>
                                            <td>{!! $user_investment->investment->property_listing->title !!}</td>
                                            <td class="text-center">{!! $user_investment->purchased_slot !!}</td>
                                            <td class="text-success">NGN{!! number_format($user_investment->amount, 2) !!}</td>
                                            <td>{!! $user_investment->receipt_id !!}</td>
                                            <td class="text-center"> <i class="fa fa-{{ $user_investment->is_paid ? 'check-circle text-success' : 'times-circle text-danger' }}"></i> </td>
                                            <td class="text-center">{!! $user_investment->created_at !!}</td>
                                        </tr>
                                        <?php $count++; ?>
                                    @endforeach
                                @else 
                                <tr>
                                    <td colspan="7" class="text-center text-danger">No investment record.</td>
                                </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- rent payment div -->
                <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                    <div class="table-responsive">
                        <table class="table table-stripped table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th class="text-center">Amount</th>
                                    <th class="text-center">Receipt</th>
                                    <th class="text-center">Payment status</th>
                                    <th class="text-center">Date</th>
                                </tr>
                            </thead>

                            <tbody>
                                @if($user->rent_payout->count() > 0)
                                    <?php $count = 1; ?>
                                    @foreach($user->rent_payout as $rent_payout)
                                        <tr>
                                            <td>{{ $count }}</td>
                                            <td>{!! $rent_payout->investment->property_listing->title !!}</td>
                                            <td class="text-center text-success">NGN{!! number_format($rent_payout->amount_paid, 2) !!}</td>
                                            <td class="text-center">{!! $rent_payout->receipt !!}</td>
                                            <td class="text-center"><i class="fa fa-{!! $rent_payout->is_paid ? 'check-circle text-success' : 'times-cirlce text-danger' !!}"></i></td>
                                            <td class="text-center">{!! $rent_payout->created_at !!}</td>
                                        </tr>
                                        <?php $count++; ?>
                                    @endforeach
                                @else
                                    <tr>
                                        <td class="text-center text-danger" colspan="6">No investment rent payment available for this user</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
                    <div class="table-responsive">
                        <table class="table table-stripped table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th class="text-center">Amount</th>
                                    <th class="text-center">Receipt</th>
                                    <th class="text-center">Payment status</th>
                                    <th class="text-center">Date</th>
                                </tr>
                            </thead>

                            <tbody>
                                @if($user->sell_off_payout->count() > 0)
                                    <?php $count = 1; ?>
                                    @foreach($user->sell_off_payout as $sell_off_payout)
                                        <tr>
                                            <td>{{ $count }}</td>
                                            <td> {!! $sell_off_payout->investment->property_listing->title !!} </td>
                                            <td class="text-center text-success">NGN{!! $sell_off_payout->amount_paid !!}</td>
                                            <td class="text-center">{!! $sell_off_payout->receipt !!}</td>
                                            <td class="text-center"><i class="fa fa-{!! $sell_off_payout->is_paid ? 'check-circle text-success' : 'times-circle text-danger' !!}"></i></td>
                                            <td class="text-center">{!! $sell_off_payout->created_at !!}</td>
                                        </tr>
                                        <?php $count++; ?>
                                    @endforeach
                                @else
                                    <tr>
                                        <td class="text-center text-danger" colspan="6">
                                            No investment sell-off payment available to this user.
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection