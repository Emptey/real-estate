@extends('v1.master.admin')

@section('title', 'Dashboard')

@section('content')
    
        <div class="row">
            <div class="col-md-12 col-lg-12 col-sm-12 text-right no-padding">
                <a href="#" class="btn btn-info">Report <i class="fa fa-download"></i></a>
            </div>
        </div>
        
        <div class="row" style="margin-top:1.5%">
            <div class="col-md-8 col-lg-8 col-sm-12 shadow mb-5 rounded div-space" style="margin-right: 5%">
                Transaction info goes here
                <br>
                <br>
                <br>
                <br>
                <br><br>
            </div>
            <div class="col-md-3 col-lg-3 col-sm-12 shadow mb-5 rounded div-space">
                Visitors info goes here.... I guess
                <br>
                <br>
                <br>
                <br>
                <br><br>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12 col-lg-12 col-sm-12 shadow mb-5 rounded div-space">
                Chart goes here
                <br><br><br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
            </div>
        </div>
@endsection