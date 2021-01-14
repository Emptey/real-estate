@extends('v1.master.admin')

@section('title', 'add property')

@section('content')
    <div class="row">
        <div class="col-md-12 col-lg-12 col-sm-12  no-padding">
            <div class="row">
                <div class="col-md-6">
                    <h4 class="float-left"> <i class="fa fa-building"></i> Property listing</h4>
                </div>

                <div class="col-md-6 text-right">

                    <a href="{{ route('get-property-listing') }}" class="btn btn-danger btn-lg text-dark {{ app('App\Http\Controllers\Helper')->superAdminStatus() }}" style="display:inline-block; margin-right: 1% !important">
                        Cancel
                        <i class="fa fa-times"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="row first-content-row">
        <div class="col-md-12 col-lg-12 col-sm-12 no-padding">
            <div class="shadow mb-5 rounded big-wrapper">

                <div class="container">
                    <div class="row">
                        <div class="col-md-12 col-lg-12 col-sm-12 text-center">
                            <ul class="counter">
                                <li>1</li>
                                <li>2</li>
                                <li class="active">3</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <form action="{{ route('post-add-property-third') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="id" value="{{ session()->get('add.property') }}">
                    <div class="form-row">
                        <div class="col">
                            <div class="form-group">
                                <label for="front_view">Front view</label>
                                <input type="file" name="front_view" id="front_picture" class="form-control form-control-lg" />
                                @error('front_view')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col">
                            <div class="form-group">
                                <label for="side_view">Side view</label>
                                <input type="file" name="side_view" id="side_view" class="form-control form-control-lg" />
                                @error('side_view')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                    </div>

                    <div class="form-row">
                        <div class="col">
                            <label for="back_view">Back view</label>
                            <input type="file" name="back_view" id="back_view" class="form-control form-control-lg" />
                            @error('back_view')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col"></div>
                    </div>                    

                    <div style="margin-top: 1.5%">
                        <button type="submit" class="btn btn-success btn-lg">Save <i class="fa fa-check"></i></button>
                    </div>

                </form>

            </div>
        </div>
    </div>
@endsection