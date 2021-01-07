@extends('v1.master.admin_auth')

@section('title', '2FA')

@section('content')
    <!-- <div class="col-md-12 col-lg-12 col-sm-12" style="background-color:gree">
        
    </div> -->
    <div class="row">
        <div class="col-md-6 offset-md-3 shadow mb-5 rounded" style="margin-top:10%; padding:0">
        <div class="container">
            <div class="row">
                
                <div class="col-md-6 col-lg-6 col-sm-12" id="login-div-left">
                    <div class="admin-login-link-container">
                        <a href="#" class="admin-login-link">Login</a>
                        <a href="#" class="admin-login-link admin-login-link-active">2FA </a>
                    </div>

                    <div style="margin: 15% auto;">
                    </div>

                  <div class="container-fluid" style="border:2px solid red">
                    <div class="row" style="padding:0; border:20px solid blue; margin:0">
                        <div class="col-md-12 col-lg-12 col-sm-12 text-center" style="border:40px solid green">
                            <h2>Company Name</h2>
                        </div>
                    </div>
                  </div>
                </div>

                
                <div class="col-md-6 col-lg-6 col-sm-12" id="login-div-right">
                    <form action="{{ route('post-admin-2fa') }}" method="post">
                    @csrf
                        <div id="shield-container">
                            <i class="fa fa-key info text-info"></i>
                        </div>

                        <div class="form-group input-group-lg">
                            <label for="login_token">Token</label>
                            <input type="text" name="login_token" id="login_token" class="form-control lg" autocomplete="off" placeholder="Enter Token" 
                                value="{{Request::old('email') }}"  aria-describedby="inputGroup-sizing-lg" />
                            
                            @error('login_token')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror

                        </div>
                       
                        <div class="form-group input-group-lg">
                            <button type="submit" class="btn btn-info btn-lg">
                                Verify <i class="fa fa-sign-in" aria-hidden="true"></i>
                            </button>
                        </div>


                    </form>
                </div>
            </div>
        </div>
        </div>
    </div>
@endsection('content')