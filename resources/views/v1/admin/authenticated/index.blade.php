@extends('v1.master.admin')

@section('title', 'Dashboard')

@section('content')
    <div class="row">
        <div class="col-md-12 col-lg-12 col-sm-12 text-right no-padding">
            <a href="#" class="btn btn-info btn-lg">
                Report 
                <i class="fa fa-download"></i>
            </a>
        </div>
    </div>
    
    <div class="row" style="margin-top:1.5%;">
        <div class="col-md-8 col-lg-8 col-sm-12 no-padding-left">
            <div class=" shadow mb-5 rounded" style="padding:1.1%">
                <h3 class="title">
                    Investment chart 
                    <i class="float-right fa fa-times"></i> 
                </h3>
                <br>
                <br>
                <br>
                <br>
                <br><br>
            </div>
        </div>
        
        <div class="col-md-4 col-lg-4 col-sm-12 no-padding">
            <div class="shadow mb-5 rounded medium-div-spacing">
                <h3 class="title">
                    Completed investment 
                    <i class="float-right fa fa-times"></i> 
                </h3>
            <br>
            <br>
            <br>
            <br>
            <br><br>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12 col-lg-12 col-sm-12 shadow mb-5 rounded div-space">
            <h3 class="title">
                User registration rate 
                <i class="float-right fa fa-times"></i> 
            </h3>
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

    <div class="row">
        <div class="col-md-6 col-lg-6 col-sm-12 no-padding-left">
            <div class="shadow mb-5 rounded medium-div-spacing">
               <h3 class="title">
                   Total transactions
                   <i class="float-right fa fa-times"></i>
                </h3>
            </div>
        </div>

        <div class="col-md-6 col-lg-6 col-sm-12 no-padding">
            <div class=" shadow mb-5 rounded medium-div-spacing">
                <h3 class="title">
                    Recent investors
                    <i class="float-right fa fa-times"></i>
                </h3>
            </div>
        </div>
    </div>
@endsection