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
                            <span class="progress-circle-active circle">
                                <span class="iconify text-white" data-icon="ant-design:check-outlined" data-inline="false"></span>
                            </span>
                            <span class="progress-circle circle"></span>
                            <span class="progress-circle circle"></span>

                            <div class="content">
                                <h2>Sign up with us.</h2>
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

                            <h3 class="heading mt-4 mb-5">
                                Register
                            </h3>

                            <form action="{{ route('post-user-register') }}" method="post">
                                @csrf
                                <div class="form-group">
                                    <input type="email" name="email" id="email" autocomplete="off" placeholder="Email" class="form-control form-control custom-input @error('email') mb-2 @enderror" />
                                    @error('email')
                                        <span class="text-white">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <input type="number" name="phone" id="phone" autocomplete="off" placeholder="Phone" class="form-control form-control custom-input @error('phone') mb-2 @enderror" />
                                    @error('phone')
                                        <span class="text-white">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <input type="password" name="password" id="password" autocomplete="off" placeholder="Password" class="form-control form-control custom-input @error('password') mb-2 @enderror " />
                                    @error('password')
                                        <span class="text-white">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <button type="submit" class="btn custom-btn"> Next </button>
                                </div>
                            </form>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection