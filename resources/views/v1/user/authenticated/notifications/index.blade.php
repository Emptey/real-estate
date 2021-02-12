@extends('v1.master.user')

@section('title', 'notification')

@section('content')
   @for($i = 1; $i <= 5; $i++)
   <div class="row">
        <div class="col-md-12 col-lg-12 col-sm-12">
            <div class="small-box mb-5">
                <div class="text-left">
                    <h4 class="notification-header">Title</h4>
                    <p class="notification-text">
                        Lorem ipsum dolor sit amet consectetur adipisicing elit. Nemo expedita eligendi nihil praesentium! Ipsam vel libero esse, aliquam deserunt error veritatis quidem asperiores nam mollitia eos dignissimos. Earum, reiciendis fugit.
                    </p>
                </div>
            </div>
        </div>
    </div>
   @endfor
@endsection