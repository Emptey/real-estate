@extends('v1.master.user_auth')

@section('title', 'register')

@section('content')
    <div class="row">
                  

        <div class="col-md-6 col-lg-6 col-sm-3 message-box">
            <!-- message box -->
            <a class="navbar-brand" href="#">Navbar</a>

            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-10 col-lg-10 col-sm-10 offset-md-1 offset-lg-1 offset-sm-1 text-center">
                        <div class="left-container">
                        <span class="progress-circle-active circle"><span class="iconify text-white" data-icon="ant-design:check-outlined" data-inline="false"></span></span>
                            <span class="progress-circle-active circle"><span class="iconify text-white" data-icon="ant-design:check-outlined" data-inline="false"></span></span>
                            <span class="progress-circle-active circle"><span class="iconify text-white" data-icon="ant-design:check-outlined" data-inline="false"></span></span>

                            <div class="content">
                                <h2>Lets know you further.</h2>
                                <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Quam, ducimus asperiores temporibus reprehenderit, ea quo doloremque in voluptas quas provident nostrum blanditiis reiciendis odio consequuntur dolorem repudiandae aut mollitia suscipit!</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-lg-6 col-sm-3 field-box">
            <!-- navigation -->
            <x-user-general-nav />
            <!-- input field -->
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-10 col-lg-10 col-sm-12 offset-md-1 offset-lg-1offset-sm-1 text-center">
                        <div class="right-container">
                        <span class="iconify icon" data-icon="feather:user-plus" data-inline="false"></span>

                            <h3 class="heading">
                                Register
                            </h3>

                            <form action="" method="post">
                                @csrf
                                <div class="form-group">
                                    <input type="text" name="country" id="country" autocomplete="off" placeholder="Country" class="form-control form-control custom-input @error('country') mb-2 @enderror" 
                                        value="{{ Request::old('country') }}" />
                                    @error('country')
                                        <span class="text-white">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <input type="text" name="state" id="state" autocomplete="off" placeholder="State" class="form-control form-control custom-input @error('state') mb-2 @enderror" 
                                        value="{{ Request::old('state') }}" />
                                    @error('state')
                                        <span class="text-white">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <input type="text" name="address" id="address" autocomplete="off" placeholder="Address" class="form-control form-control custom-input @error('address') mb-2 @enderror" 
                                        value="{{ Request::old('address') }}" />
                                    @error('address')
                                        <span class="text-white">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <button type="submit" class="btn custom-btn"> Finish </button>
                                </div>
                            </form>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection