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
                                <li>1</li>
                                <li class="active">2</li>
                                <li>3</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <form action="{{ route('post-add-property-second') }}" method="post">
                    @csrf
                    
                    <div class="form-row">
                        <div class="col">
                            <div class="form-group">
                                <label for="cost">Cost</label>
                                <input type="number" name="cost" id="cost" class="form-control form-control-lg"
                                    required="yes" autocomplete="off" placeholder="Enter property cost" value="{{ Request::old('cost') }}" />
                                @error('cost')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col">
                            <div class="form-group">
                                <label for="Mgnt_fee">Mgnt Fee</label>
                                <input type="number" name="mgnt_fee" id="mgnt_fee" class="form-control form-control-lg"
                                    required="yes" autocomplete="off" placeholder="Enter Management Fee" value="{{ Request::old('mgnt_fee') }}" />
                                @error('mgnt_fee')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                    </div>

                    <div class="form-row">
                        <div class="col">
                            <div class="form-group">
                                <label for="sell-off-price">Sell-off price</label>
                                <input type="number" name="sell_off_price" id="sell_off_price" class="form-control form-control-lg"
                                    required="yes" autocomplete="off" placeholder="Enter sell-off price" value="{{ Request::old('sell_off_price') }}" />
                                @error('sell_off_price')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col">
                            <div class="form-group">
                                <label for="sell_off_roi">Sell-off roi</label>
                                <input type="number" name="sell_off_roi" id="sell_off_roi" class="form-control form-control-lg"
                                    required="yes" autocomplete="off" placeholder="Enter sell-off roi" value="{{ Request::old('sell_off_roi') }}" />
                                @error('sell_off_roi')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                    </div>

                    <div class="form-row">
                        <div class="col">
                            <div class="form-group">
                                <label for="rentage-price">Rentage price</label>
                                <input type="number" name="rentage_price" id="rentage_price" class="form-control form-control-lg"
                                    autocomplete="off" placeholder="Enter amount for rentage" value="{{ Request::old('rentage_price') }}" />
                                @error('rentage_price')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col">
                            <div class="form-group">
                                <label for="rentage_roi">Rentage roi</label>
                                <input type="number" name="rentage_roi" id="rentage_roi" class="form-control form-control-lg"
                                    autocomplete="off" placeholder="Enter rentage roi" value="{{ Request::old('rentage_roi') }}" />
                                @error('rentage_roi')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="form-check">
                        <input type="checkbox" name="is_rentable" id="is_rentable" class="form-check-input" value="1" style="margin-top: 0.75%" />
                        <label class="form-check-label" for="is_rentable">rentable?</label>
                    </div>

                    <div style="margin-top:1%">
                        <button type="submit" class="btn btn-success btn-lg">Continue <i class="fa fa-arrow-right"></i></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection