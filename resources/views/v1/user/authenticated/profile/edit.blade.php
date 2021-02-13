@extends('v1.master.user')

@section('title', 'edit profile')

@section('content')
    <div class="row">
        <div class="col-md-12 col-lg-12 col-sm-12">
            <div class="small-box">
                <h2 class="box-title-2">Personal info</h2>
                <form action="{{ route('post-edit-user-profile-personal') }}" method="post">
                    @csrf
                    <div class="text-underline pb-4 mt-5">
                        <div class="form-group text-left mt-4">
                            <input type="text" class="custom-input-2" name="email" id="email" placeholder="Email" required="yes" value="{{ \Auth::user()->email }}" 
                                autocomplete="off" />
                            @error('email')
                                <span class="text-danger on text-left">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group text-left mt-4">
                            <input type="number" class="custom-input-2" name="phone" id="phone" placeholder="Phone" required="yes" value="{{ \Auth::user()->phone }}" 
                                autocomplete="off" />
                            @error('phone')
                                <span class="text-danger on text-left">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group text-left mt-4">
                            <button type="submit" class="btn custom-btn-2">Update info</button>
                        </div>
                    </div>
                </form>

                <h2 class="box-title-2">Bank info</h2>
                <form action="{{ route('post-edit-user-profile-bank') }}" method="post">
                    @csrf
                    <div class="text-underline pb-4 mt-5">
                        <div class="form-group text-left mt-4">
                            <input type="text" class="custom-input-2" name="account_name" id="account_name" placeholder="Account name" required="yes" 
                                autocomplete="off" value="{{ !is_null(\Auth::user()->user_bank) ? \Auth::user()->user_bank->pluck('account_name')->first() : '' }}" />
                            @error('account_name')
                                <span class="text-left text-danger on mt-3">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group text-left mt-4">
                            <input type="number" class="custom-input-2" name="account_number" id="account_number" placeholder="Account number" required="yes" 
                                value="{{ !is_null(\Auth::user()->user_bank) ? \Auth::user()->user_bank->pluck('account_number')->first() : '' }}" autocomplete="off" />
                            @error('account_number')
                                <span class="text-left text-danger on mt-3">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group text-left mt-4">
                            <input type="text" class="custom-input-2" name="bank" id="bank" placeholder="Bank name" required="yes" 
                                value="{{ !is_null(\Auth::user()->user_bank) ? \Auth::user()->user_bank->pluck('bank')->first() : '' }}" autocomplete="off" />
                            @error('bank')
                                <span class="text-left text-danger on mt-3">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group text-left mt-4">
                            <button type="submit" class="btn custom-btn-2">Update info</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection