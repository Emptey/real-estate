@extends('v1.master.user')

@section('title', 'notification')

@section('content')
  @if(!is_null($notification))
    @foreach($notification as $notifications)
    <div class="row">
        <div class="col-md-12 col-lg-12 col-sm-12">
            <div class="small-box mb-5 p-5">
                <div class="text-left">
                    <h4 class="{{ app('App\Http\Controllers\Helper')->getNotificationColor($notifications) }}">{{ ucfirst($notifications->title) }}</h4>
                    <p class="notification-text">
                        {{ ucfirst($notifications->message) }}
                    </p>
                </div>
            </div>
        </div>
    </div>
    @endforeach
  @else
    <div class="row">
        <div class="col-md-12 col-lg-12 col-sm-12 text-center">
            <p class="notification-text text-danger">
                There are no notifications available.
            </p>
        </div>
    </div>
  @endif
@endsection