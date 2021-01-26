@extends('v1.master.admin')

@section('title', 'notification')

@section('content')
    <div class="row">
        <div class="col-md-12 col-lg-12 col-sm-12">
            <h4><i class="fa fa-bell"></i> Notification</h4>
        </div>
    </div>

    <div class="row first-content-row">
        <div class="col-md-12 col-lg-12 col-sm-12">
            <div class="shadow mb-5 rounded" style="padding: 2%">
                <form action="{{ route('post-admin-notification') }}" method="post" style="width: 600px">
                    @csrf
                    <div class="form-group">
                        <label for="title">Title</label>
                        <input type="text" name="title" id="title" class="form-control form-control-lg"
                            placeholder="Enter title" autocomplete="off" required="yes" />
                        @error('title')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="message">Message</label>
                       <textarea name="message" id="message" class="form-control form-control-lg" placeholder="Enter message" cols="30" rows="10"></textarea>
                       @error('message')
                            <span class="text-danger">{{ $message }}</span>
                       @enderror
                    </div>
                    <div class="from-group">
                        <button class="btn btn-success btn-lg" type="submit">Send notification <i class="fa fa-check-circle"></i></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection