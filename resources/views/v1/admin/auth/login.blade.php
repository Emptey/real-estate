@extends('v1.master.admin_auth')

@section('title', 'Admin login')

@section('content')
    <!-- <div class="col-md-12 col-lg-12 col-sm-12" style="background-color:gree">
        
    </div> -->
    <div class="row">
        <div class="col-md-6 offset-md-3 shadow mb-5 rounded" style="margin-top:10%; padding:0">
        <div class="container">
            <div class="row">
                
                <div class="col-md-6 col-lg-6 col-sm-12" id="login-div-left">
                    <div class="admin-login-link-container">
                        <a href="#" class="admin-login-link admin-login-link-active">Login</a>
                        <a href="#" class="admin-login-link">2FA </a>
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
                    <form action="{{ route('post-admin-login') }}" method="post">
                    @csrf
                        <div id="shield-container">
                            <i class="fa fa-shield info text-info"></i>
                        </div>

                        <div class="form-group input-group-lg">
                            <label for="email">Email {{ \Hash::make('password') }} </label>
                            <input type="email" name="email" id="email" class="form-control sm" autocomplete="off" placeholder="Enter Email" 
                                value="{{Request::old('email') }}"  aria-describedby="inputGroup-sizing-lg" />
                            
                            @error('email')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror

                        </div>
                       

                        <div class="form-group input-group-lg">
                            <label for="password">Password</label>
                            <input type="password" name="password" id="password" placeholder="Enter Password" class="form-control" 
                                aria-describedby="inputGroup-sizing-lg"/>
                            
                            @error('password')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror

                        </div>
                       

                        <div class="form-group input-group-lg">
                            <button type="submit" class="btn btn-info btn-lg">
                                Proceed <i class="fa fa-sign-in" aria-hidden="true"></i>
                            </button>
                        </div>


                    </form>
                </div>
            </div>
        </div>
        </div>
    </div>
@endsection('content')