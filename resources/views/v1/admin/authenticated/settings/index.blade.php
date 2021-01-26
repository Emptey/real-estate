@extends('v1.master.admin')

@section('title', 'settings')

@section('content')
    <div class="row">
        <div class="col-md-12 col-lg-12 col-sm-12">
            <h4><i class="fa fa-cog"></i> Settings</h4>
        </div>
    </div>

    <div class="row first-content-row">
        <div class="col-md-7 col-lg-7 col-sm-12">
            <div class="shadow mb-4 rounded x4-padding">
                <h3 class="title">Basic Info</h3>
                <p class="x4-margin-top"><i class="fa fa-shield text-success"></i> 2FA is ON</p>
                <p class="overview-title x2-margin-top"> <span class="font-weight-bold">Name:</span> {{ ucwords(\Auth::user()->full_name) }}</p>
                <p class="overview-title x2-margin-top"> <span class="font-weight-bold">Email:</span> {{ \Auth::user()->email }}</p>
                <p class="overview-title x2-margin-top"> <span class="font-weight-bold">Last seen:</span> {{ substr(\Auth::user()->updated_at, 0, 10) }}</p>
            </div>

            <div class="shadow mb-5 rounded x4-padding">
                <h3 class="title">Change password</h3>
                <form action="" method="post" style="margin-top: 5%; width:500px">
                    <div class="form-group">
                        <label for="current_password">Current password</label>
                        <input type="password" name="password" id="password" class="form-control form-control-lg"
                            placeholder="Enter current password" required/>
                    </div>

                    <div class="form-group">
                        <label for="new_password">New password</label>
                        <input type="password" name="new_password" id="new_password" class="form-control form-control-lg"
                            placeholder="Enter new password" required />
                    </div>

                    <div class="form-group">
                        <label for="confirm_password">Confirm new password</label>
                        <input type="password" name="" id="" class="form-control form-control-lg"
                            placeholder="Confirm new password" required />
                    </div>

                    <div class="form-group">
                        <button class="btn btn-success btn-lg">Change <i class="fa fa-check-circle"></i></button>
                    </div>
                </form>
            </div>
        </div>

        <div class="col-md-5 col-lg-5 col-sm-12">
            <div class="shadow mb-5 rounded x4-padding">
                <h3 class="title">Recent activity</h3>
               <div class="x4-margin-top">
                    @foreach($activities as $activities)
                        <p class="x5-margin-top">
                            <i class="fa fa-plus text-success" style="margin-right: 2%"></i>
                            {!! $activities->activity !!}
                        </p>
                    @endforeach
               </div>
            </div>
        </div>
    </div>
@endsection