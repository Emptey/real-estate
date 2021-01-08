@extends('v1.master.admin')

@section('title', 'view info')

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
                </div>
            </div>
        </div>
    </div>
@endsection