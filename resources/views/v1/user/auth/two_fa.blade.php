@extends('v1.master.user_auth')

@section('title', 'login verification')

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

                            <div class="content">
                                <h2>Two factor auth.</h2>
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
                            <span class="iconify icon" data-icon="bi:shield-check" data-inline="false"></span>

                            <h3 class="heading">
                                2 FA
                            </h3>

                            <form action="{{ route('post-user-two-fa') }}" method="post">
                                @csrf

                                <div class="form-group">
                                    <input type="nuber" name="pin" id="pin" autocomplete="off" placeholder="Pin" class="form-control form-control custom-input @error('pin') mb-2  @enderror" />
                                    @error('pin')
                                        <span class="text-white">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <button type="submit" class="btn custom-btn"> Validate </button>
                                </div>
                            </form>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection