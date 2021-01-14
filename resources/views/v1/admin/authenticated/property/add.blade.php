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
                <!-- <h3 class="title">List Property</h3> -->

                <div class="container">
                    <div class="row">
                        <div class="col-md-12 col-lg-12 col-sm-12 text-center">
                            <ul class="counter">
                                <li class="active">1</li>
                                <li>2</li>
                                <li>3</li>
                            </ul>
                        </div>
                    </div>
                </div>
                
                <form action="{{ route('post-add-property-first') }}" method="post">
                    @csrf
                    <div class="form-row">
                        <div class="col">
                            <div class="form-group">
                                <label for="title">Title</label>
                                <input type="text" name="title" id="title" class="form-control form-control-lg" 
                                    required="yes" autocomplete="off" placeholder="Enter title" value="{{ Request::old('title') }}" />
                                @error('title')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col">
                            <div class="form-group">
                                <label for="address">Address</label>
                                <input type="text" name="address" id="address" class="form-control form-control-lg" 
                                    required="yes" autocomplete="off" placeholder="Enter property address"  value="{{ Request::old('address') }}"/>
                                @error('address')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="col">
                            <div class="form-group">
                                <label for="bedroom">Bedroom</label>
                                <input type="number" name="bedroom" id="bedroom" class="form-control form-control-lg" 
                                    required="yes" autocomplete="off" placeholder="Enter no. of bedroom"  value="{{ Request::old('bedroom') }}">
                                @error('bedroom')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col">
                            <div class="form-group">
                                <label for="bathroom">Bathroom</label>
                                <input type="number" name="bathroom" id="bathroom" class="form-control form-control-lg"
                                    required="yes" autocomplete="off" placeholder="Enter no. of bathrooms"  value="{{ Request::old('bathroom') }}"/>
                                @error('bathroom')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="col">
                            <div class="form-group">
                                <label for="description">Description</label>
                                <textarea name="description" id="description" cols="30" rows="10" required="yes" 
                                    placeholder="Enter property description" class="form-control">{{ Request::old('description') }}</textarea>
                                @error('description')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>    
                        </div>

                        <div class="col">

                            <div class="form-group">
                                <label for="toilet">Toilet</label>
                                <input type="number" name="toilet" id="toilet" class="form-control form-control-lg"
                                    required="yes" autocomplete="off" placeholder="Enter no. of toilets"  value="{{ Request::old('toilet') }}"/>
                                @error('toilet')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group" style="margin-top: 3%">
                                <label for="slot">Slot</label>
                                <input type="number" name="slot" id="slot" class="form-control form-control-lg"
                                    required="yes" autocomplete="off" placeholder="Enter no. of slots" value="{{ Request::old('slot') }}"/>
                                @error('slot')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group" style="margin-top: 3%">
                                <label for="duration">Duration</label>
                                <input type="number" name="duration" id="duration" class="form-control form-control-lg"
                                    required="yes" autocomplete="off" placeholder="Enter property investment duration" value="{{ Request::old('duration') }}"/>
                                @error('duration')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                        </div>
                    </div>

                    <div>
                        <button type="submit" class="btn btn-success btn-lg">Continue <i class="fa fa-arrow-right"></i> </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection