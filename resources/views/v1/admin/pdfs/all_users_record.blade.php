@extends('v1.master.pdf')

@section('content')

    <div class="table-responsive">
        <div class="table-head text-center">
            <h3>Logo</h3>
            <h5>Address: this is where the address goes, phone: 080xxxxxxxx</h5>
        </div>

        <table class="table table-stripped">
            <thead>
                <tr class="table-primary">
                    <th>#</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Gender</th>
                    <th>Role</th>
                    <th>Joined</th>
                    <th>Status</th>
                </tr>
            </thead>
            
            <tbody>
            <?php $count = 1; ?>
                @foreach($users as $user)
                    <tr>
                        <td>{!! $count !!}</td>
                        <td>{!! strtolower($user->full_name) !!}</td>
                        <td>{!! strtolower($user->email) !!}</td>
                        <td>{!! strtolower($user->gender->gender) !!}</td>
                        <td>{!! app('App\Http\Controllers\Helper')::user_role($user) !!}</td>
                        <td>{!! app('App\Http\Controllers\Helper')::justDate($user->created_at) !!}</td>
                        <td>{!! $user->is_active? '<span style="color:rgb(0, 165, 41)">active</span>' : '<span style="color:rgb(128, 0, 0)">inactive</span>' !!}</td>
                    </tr>
                    <?php $count++; ?>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection