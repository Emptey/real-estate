@extends('v1.master.user')

@section('title', 'dashboard')

@section('content')
    <div class="row">
        <div class="col-md-8 col-lg-8 col-sm-12 no-padding">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-6 col-lg-6 col-sm-12">
                        <div class="small-box">
                            <h2 class="box-title-2">Title</h2>
                            <h2 class="box-title">40</h2>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-6 col-sm-12">
                        <div class="small-box">
                            <h2 class="box-title-2">Title</h2>
                            
                            <h2 class="box-title">39</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-lg-4 col-sm-12">
            <div class="small-box">
                <h2 class="box-title-2">Transactions</h2>
                <h2 class="box-title">39</h2>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8 col-lg-8 col-sm-12">
            <div class="small-box">
                <h2 class="box-title-2">Chart 1</h2>
                <canvas id="myChart" width="300" height="100"> </canvas> 

                <!-- <script>
                    
                </script> -->
            </div>
        </div>
        <div class="col-md-4 col-lg-4 col-sm-12">
            <div class="small-box fit-parent">
                <h2 class="box-title-2">
                    Something
                </h2>

                <h2 class="box-title">
                    25
                </h2>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12 col-lg-12 col-sm-12">
            <div class="small-box">
                <h2 class="">Chart 2</h2>
                <canvas id="myChart2" width="300" height="100"> </canvas> 
            </div>
        </div>
    </div>
@endsection