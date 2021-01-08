@extends('v1.master.admin')

@section('title', 'user management')

@section('content')
    <div class="row">
        <div class="col-md-12 col-lg-12 col-sm-12  no-padding">
            <div class="row">
                <div class="col-md-6">
                    <h4 class="float-left"> <i class="fa fa-users"></i> User Management</h4>
                </div>

                <div class="col-md-6 text-right">
                    <a href="/authenticator/authorized/user/generate/pdf" class="btn btn-warning btn-md text-dark" style="display:inline-block; margin-left: 5%">
                        Export
                        <i class="fa fa-file-pdf"></i>
                    </a>

                    <a href="{{ route('add-user') }}" class="btn btn-info btn-md text-dark {{ app('App\Http\Controllers\Helper')->superAdminStatus() }} " style="display:inline-block; margin-right: 1% !important">
                        User
                        <i class="fa fa-plus"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12 no-padding first-content-row">
            <div class="shadow mb-5 rounded big-wrapper">
                <form action="{{ route('search-user') }}" method="post" style="margin-bottom: 1.7%">
                    @csrf

                    <div class="input-group" style="width:400px;">
                        <input type="text" name="search" class="form-control input-lg" id="search" placeholder="search" />
                        <button type="submit" class="btn btn-primary" style="border-top-right-radius:360px; border-bottom-right-radius:360px">
                            <i class="fa fa-search"></i> 
                        </button>
                    </div>

                        @error('search')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                </form>

                <div class="table-responsive">
                    <table class="table borderless table-hover">
                        <thead>
                            <tr class="">
                                <th>#</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Joined</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Options</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php $count = 1; ?>
                            @foreach($users as $user)
                            <tr>
                                <td>
                                    {!! $count ++ !!}
                                </td>
                                <td>
                                    {!! $user->full_name != '' ? $user->full_name : 'unavailable' !!}
                                </td>
                                <td>
                                    {!! $user->email !!}
                                </td>
                                <td >
                                    {!! app('App\Http\Controllers\Helper')::user_role($user) !!}
                                </td>
                                <td>
                                    {!! app('App\Http\Controllers\Helper')::justDate($user->created_at) !!}
                                </td>
                                <td class="text-center">
                                    {!! app('App\Http\Controllers\Helper')->getStatus($user) !!}
                                </td>
                                <td class="text-center">
                                    <a href="" class="btn btn-light">Views</a>
                                    <a href="{{ route('change-user-status', \Crypt::encrypt($user->id)) }}" class="{!! app('App\Http\Controllers\Helper')->getButton($user) !!} text-light"> {!! $user->is_active ? 'Disable' : 'Enable' !!} </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="pagination">
                    {{ $users->links() }}
                </div>

            </div>

        </div>

    </div>
@endsection