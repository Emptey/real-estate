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
                            <span class="progress-circle circle"></span>

                            <div class="content">
                                <h2>What do we call you?</h2>
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

                            <form action="{{ route('post-user-register-step-two') }}" method="post">
                                @csrf
                                <div class="form-group">
                                    <input type="text" name="fname" id="fname" autocomplete="off" placeholder="Full name" class="form-control form-control custom-input @error('fname') mb-2 @enderror" />
                                    @error('fname')
                                        <span class="text-white">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <select name="gender" id="gender" class="form-control form-control custom-input @error('gender') mb-2 @enderror">
                                       @foreach($gender as $genders)
                                            <option value="{!! $genders->id !!}">{!! strtolower($genders->gender) !!}</option>
                                       @endforeach
                                    </select>
                                    @error('gender')
                                        <span class="text-white">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <input type="date" name="dob" id="dob" autocomplete="off" placeholder="Date of birth" class="form-control form-control custom-input @error('dob') mb-2 @enderror" />
                                    @error('dob')
                                        <span class="text">
                                            {{ $message }}
                                        </span>
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