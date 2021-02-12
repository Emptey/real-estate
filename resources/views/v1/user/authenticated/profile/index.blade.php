@extends('v1.master.user')

@section('title', 'profile')

@section('content')
   <div class="row">
       <div class="col-md-6 col-lg-6 col-sm-12">
            <div class="small-box">
                <img src="{{ asset('assets/img/user_female.png') }}" alt="user-avatar" class="img img-responsive user-img mb-3" title="avatar" />
                <h3 class="profile-header text-left mt-4 mb-5">Profile 
                    <a href="#" class="float-right box-nav">
                        <span class="iconify icon" data-icon="la:user-edit" data-inline="false"></span>
                    </a> 
                </h3>

                <div class="text-right text-underline">
                    <p class="profile-text mt-4">
                        {!! ucwords(\Auth::user()->full_name) !!}
                        <span class="float-right profile-text-verified">
                            Verified 
                            <!-- <span class="iconify" data-icon="ant-design:check-circle-outlined" data-inline="false"></span> -->
                            <span class="iconify" data-icon="akar-icons:circle-check" data-inline="false"></span>
                        </span> 
                    </p>
                </div>

                <div class="text-underline">
                    <p class="profile-text mt-4">
                        {!! \Auth::user()->phone !!}
                    </p>
                </div>

                <div class="text-underline mb-5">
                    <p class="profile-text mt-4">
                        {!! \Auth::user()->email !!}
                    </p>
                </div>
            </div>
       </div>
       <div class="col-md-6 col-lg-6 col-sm-12 no-padding">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12 col-lg-12 col-sm-12">
                        <div class="small-box">
                            <h2 class="profile-header mb-5">My bank 
                                <a href="#" class="float-right box-nav">
                                <!-- <span class="iconify" data-icon="bx:bx-pencil" data-inline="false"></span> -->
                                <span class="iconify icon" data-icon="cil:pencil" data-inline="false"></span>
                                </a>
                            </h2>

                            <div class="text-underline">
                                <p class="profile-text mt-4">
                                    {!! !is_null(\Auth::user()->user_bank()->pluck('account_name')->first()) ? ucwords(\Auth::user()->user_bank()->plcuk('account_name')->first()) : '<span class="text-danger">unavailable</span>' !!}
                                </p>
                            </div>

                            <div class="text-underline">
                                <p class="profile-text mt-4">
                                    {!! !is_null(\Auth::user()->user_bank()->pluck('account_number')->first()) ? ucwords(\Auth::user()->user_bank()->plcuk('account_number')->first()) : '<span class="text-danger">unavailable</span>' !!}
                                </p>
                            </div>

                            <div class="text-underline">
                                <p class="profile-text mt-4">
                                    {!! !is_null(\Auth::user()->user_bank()->pluck('bank')->first()) ? ucwords(\Auth::user()->user_bank()->plcuk('bank')->first()) : '<span class="text-danger">unavailable</span>' !!}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 col-lg-12 col-sm-12">
                        <div class="small-box">
                            <h2 class="profile-header mb-5">Recent activity</h2>

                            <div class="text-underline">
                                @if(!is_null($activity))
                                    @foreach($activity as $activities)
                                    <p class="profile-text mt-4">
                                        <span class="iconify text-success mr-4" data-icon="akar-icons:plus" data-inline="false"></span>   
                                        {{ ucfirst($activities->activity) }}
                                    </p>
                                    @endforeach
                                @else 
                                    <p class="text-danger profile-text">
                                        No activities.
                                    </p>
                                @endif
                               
                            </div>

                        </div>
                        
                    </div>
                </div>
            </div>
       </div>
   </div>
@endsection