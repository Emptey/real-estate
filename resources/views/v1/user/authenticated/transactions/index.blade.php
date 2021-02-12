@extends('v1.master.user')

@section('title', 'transactions')

@section('content')
    <div class="row">
        <div class="col-md-4 col-lg-4 col-sm-12">
            <div class="small-box">
                <h2 class="box-title-2">Status</h2>
                
                <div class="text-left">
                    <p class="text-success transaction-status">Incoming</p>
                    <span class="incoming-loader"></span>
                    <span class="loader-text">90</span>
                </div>

                <div class="text-left">
                    <p class="text-danger transaction-status">Outgoing</p>
                    <span class="outgoing-loader"></span>
                    <span class="loader-text">50</span>
                </div>

                <div class="text-left">
                    <p class="text-danger transaction-status">Failed</p>
                    <span class="failed-loader"></span>
                    <span class="loader-text">50</span>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-lg-4 col-sm-12">
            <div class="small-box sibling">
                <h2 class="box-title-2">Title</h2>
                <h2 class="box-title">50</h2>
            </div>
        </div>
        <div class="col-md-4 col-lg-4 col-sm-12">
            <div class="small-box sibling">
                <h2 class="box-title-2">
                    Title
                </h2>

                <h2 class="box-title">22</h2>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12 col-lg-12 col-sm-12">
            <div class="small-box">
                <div class="form-group">
                    <div class="portfolio-search-box">
                        <input type="text" name="search" id="search" placeholder="Search" autocomplete="off" required="yes" />
                        <button type="submit" class="btn-transparent">
                            <span class="iconify search-icon" data-icon="ant-design:search-outlined" data-inline="false"></span>
                        </button>
                    </div>
                </div>

                <div class="table-responsive mt-5">
                    <table class="table table-stripped table-hover">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Slot</th>
                                <th>Return</th>
                                <th>Status</th>
                                <th class="text-center">Options</th>
                            </tr>
                        </thead>

                        <tbody>
                            @for($i = 1; $i <= 5; $i++)
                            <tr class="text-left">
                                <td>Jothan {{$i}}</td>
                                <td>{{$i}}%</td>
                                <td>{{$i * 2}}</td>
                                <td>active</td>
                                <td class="text-center">
                                    <a href="#">
                                        <span class="iconify icon" data-icon="fluent:clipboard-search-24-regular" data-inline="false"></span>
                                    </a>
                                </td>
                            </tr>
                            @endfor
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection