@extends('v1.master.admin')

@section('title', 'add user')

@section('content')
    <div class="row">
        <div class="col-md-12 col-lg-12 col-sm-12  no-padding">
            <div class="row">
                <div class="col-md-6">
                    <h4 class="float-left"> <i class="fa fa-users"></i> User Management</h4>
                </div>

                <div class="col-md-6 text-right">
                    <a href="{{ route('get-admin-user-mgnt') }}" class="btn btn-danger btn-lg text-dark" style="display:inline-block; margin-left: 5%">
                        Cancel
                        <i class="fa fa-times"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12 no-padding first-content-row">
            <div class="shadow mb-5 rounded big-wrapper">
                <h3 class="title">Add user</h3>

                <form action="{{ route('post-add-user') }}" method="post">
                    @csrf
                    <div class="form-row" style="margin-top: 2%">
                        <div class="col">
                            <div class="form-group form-group-lg">
                                <label for="full_name">Full name</label>
                                <input type="text" name="full_name" id="full_name" class="form-control form-control-lg" placeholder="Enter full name" required="yes" auto-complete="off" />
                                @error('full_name')
                                    <span class="text-danger">
                                        {!! $message !!}
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="col">
                            <div class="form-group form-group-lg">
                                <label for="full_name">Email</label>
                                <input type="email" name="email" id="email" class="form-control form-control-lg" placeholder="Enter email" required="yes" auto-complete="off" />
                                @error('email')
                                    <span class="text-danger">
                                        {!! $message !!}
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="form-row" style="margin-top: 1%">
                        <div class="col">
                            <div class="form-group form-group-lg">
                                <label for="dob">Date of birth</label>
                                <input type="date" name="dob" id="dob" class="form-control form-control-lg" placeholder="Enter date of birth" required="yes" auto-complete="off" />
                                @error('dob')
                                    <span class="text-danger">
                                        {!! $message !!}
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="col">
                            <div class="form-group form-group-lg">
                                <label for="gender">Gender</label>
                                <select name="gender" id="gender" class="form-control form-control-lg">
                                    @if($genders->count() > 0)
                                        @foreach($genders as $gender)
                                            <option value="{!! $gender->id !!}">{!! $gender->gender !!}</option>
                                        @endforeach
                                    @endif
                                </select>
                                @error('gender')
                                    <span class="text-danger">
                                        {!! $message !!}
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="form-row" style="margin-top: 1%">
                        <div class="col">
                            <div class="form-group form-group-lg">
                                <label for="country">Country</label>
                                <input type="text" name="country" id="country" class="form-control form-control-lg" placeholder="Enter country" required="yes" auto-complete="off" />
                                @error('country')
                                    <span class="text-danger">
                                        {!! $message !!}
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="col">
                            <div class="form-group form-group-lg">
                                <label for="state">State</label>
                                <input type="text" name="state" id="state" class="form-control form-control-lg" placeholder="Enter state" required="yes" auto-complete="off" />
                                @error('state')
                                    <span class="text-danger">
                                        {!! $message !!}
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="form-row" style="margin-top: 1%">
                        <div class="col">
                            <div class="form-group form-group-lg">
                                <label for="address">Address</label>
                                <input type="text" name="address" id="address" class="form-control form-control-lg" placeholder="Enter address" required="yes" auto-complete="off" />
                                @error('address')
                                    <span class="text-danger">
                                        {!! $message !!}
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="col">
                            <div class="form-group form-group-lg">
                                <label for="password">Password</label>
                                <input type="password" name="password" id="password" class="form-control form-control-lg" placeholder="Enter password" required="yes" auto-complete="off" />
                                @error('password')
                                    <span class="text-danger">
                                        {!! $message !!}
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="form-row" style="margin-top: 1%">
                        <div class="col">
                            <div class="form-group form-group-lg">
                                <label for="role">Role</label>
                                <select name="role" id="role" class="form-control form-control-lg">
                                    <option value="user">user</option>
                                    <option value="staff">staff</option>
                                    <option value="super">super user</option>
                                </select>
                                @error('role')
                                    <span class="text-danger">
                                        {!! $message !!}
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="col">
                            <!-- nothing is on this column -->
                        </div>
                    </div>

                    <div>
                        <button class="btn btn-success btn-lg" type="submit">
                            Register <i class="fa fa-check-circle"></i>
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
@endsection