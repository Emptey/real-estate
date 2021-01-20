@extends('v1.master.admin')

@section('title', 'add investment')

@section('content')
    <div class="row">
        <div class="col-md-12 col-lg-12 col-sm-12  no-padding">
            <div class="row">
                <div class="col-md-8">
                    <h4 class="text-secondary"> <i class="fa fa-chart-pie"></i> 
                        Investment Manager
                    </h4>
                </div>

                <div class="col-md-4 text-right">
                    <a href="{{ route('get-admin-investment') }}" class="btn btn-danger btn-lg text-dark" 
                        style="display:inline-block; margin-right: 1% !important">
                            Cancel
                            <i class="fa fa-times"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="row first-content-row">
        <div class="col-md-12 col-lg-12 col-sm-12 no-padding">
            <div class="shadow mb-5 rounded" style="padding: 1.2%">
                <form action="{{ route('post-add-investment') }}" method="post" style="width:50%; margin-top: 2%">
                    @csrf
                    <div class="form-group">
                        @if(!is_null($properties))
                            @foreach($properties as $property)
                                <input type="hidden" name="slot" value="{!! $property->slot !!}" />
                            @endforeach
                        @endif
                        <label for="property">Property</label>
                        <select name="property" id="property" class="form-control form-control-lg">
                            @if(!is_null($properties))
                                @foreach($properties as $property)
                                    <option value="{!! $property->title !!}"> {!! $property->title !!} </option>
                                @endforeach
                            @else
                                <option value="#">No properties listed.</option>
                            @endif
                        </select>
                        @error('property')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="investment_amount">Amount/per slot</label>
                        <input type="number" name="amount" id="amount" placeholder="Enter amount per slot"
                            class="form-control form-control-lg" require />
                        @error('amount')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-success btn-lg">Save <i class="fa fa-check-circle"></i></button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection