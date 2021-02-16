@extends('v1.master.user')

@section('title', 'settings')

@section('content')
    <div class="row">
        <div class="col-md-12 col-lg-12 col-sm-12">
            <div class="small-box">
                <div class="container-fluid">
                    <div class="row text-underline mb-1 pb-3">
                        <div class="col-md-8 col-lg-8 col-sm-12 no-padding">
                            <div class="text-left ">
                                <img src="{{ asset('assets/img/'.app('App\Http\Controllers\Helper')->gender_avatar()) }}" alt="avatar" class="img img-responsive del-account-img" title="avatar" />
                                <p class="profile-text  mt-5">{{ ucwords(\Auth::user()->full_name) }}</p>
                                <p class="profile-text mt-4">{{ \Auth::user()->email }}</p>
                                <p class="profile-text mt-5">
                                    two factor authentication: 
                                    <span class="text-success">ON</span> 
                                    <span class="iconify text-success" data-icon="akar-icons:circle-check" data-inline="false"></span>
                                </p>
                            </div>
                        </div>
                        <div class="col-md-4 col-lg-4 col-sm-12 text-right">
                            <a href="#" class="del-account btn">
                                Delete account
                            </a>
                        </div>
                    </div>

                    <div class="row" style="margin-top:1%">
                        <div class="col-md-12 col-lg-12 col-sm-12 no-padding text-left">
                            <h2 class="box-title-2 mt-4">Change password</h2>

                            <form action="{{ route('post-user-settings') }}" method="post">
                                @csrf
                                <div class="form-group">
                                    <input type="password" name="password" id="password" placeholder="Current password" class="custom-input-2 mt-4 @error('password') mb-2  @enderror" required="yes"/>
                                    @error('password')
                                        <span class="text-left text-danger on">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <input type="password" name="new_password" id="new_password" placeholder="New password" class="custom-input-2 mt-3 @error('new_password') mb-2  @enderror" required="yes" />
                                    @error('new_password')
                                        <span class="text-left text-danger on">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <input type="password" name="new_password_confirmation" id="new_password_confirmation" placeholder="Confirm password" class="custom-input-2 mt-3 @error('new_password_confirmation') mb-2  @enderror" required="yes" />
                                    @error('new_password_confirmation')
                                        <span class="text-danger text-left on">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <button type="submit" class="btn custom-btn-2">Change</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
    </div>
@endsection