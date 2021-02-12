<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    


    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" 
        integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <link rel="stylesheet" href="{{ asset('assets/css/user_custom.css') }}" />
    <!-- end stylesheet -->

    <!-- google font -->
    <link rel="preconnect" href="https://fonts.gstatic.com" />
    <link href="https://fonts.googleapis.com/css2?family=Montserrat&display=swap" rel="stylesheet" />

    <!-- iconify -->
    <script src="https://code.iconify.design/1/1.0.7/iconify.min.js"></script>


    <!-- toastr -->   
    <script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.min.js" integrity="sha384-w1Q4orYjBQndcko6MimVbzY0tgp4pWB4lZ7lr30WKz0vr/aWKhXdBNmNb5D92v7s" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js"></script>
    <script src="{{ asset('assets/js/main.js') }}"></script>
    <!-- END JS -->
    <title>@yield('title')</title>
</head>
<body>
    <div class="container-fluid white-bg height-100">
        <div class="row">
            <div class="col-md-12 col-lg-12 col-sm-12">
                <div class='progress' id="progress_div">
                    <div class='bar' id='bar1'></div>
                    <div class='percent' id='percent1'></div>
                </div>
                <input type="hidden" id="progress_width" value="0">
            </div>
        </div>
        <!-- contents starts with rows -->
        <div class="row height-100">
            <div class="col-md-3 col-lg-3 col-md-2-5 col-sm-12 nav-div height-100">
                <x-user-auth-nav />
            </div>
            <div class="col-md-9 col-lg-9 col-sm-12 content-div">
                <div class="text-right top-navigation"> 
                    <a href="{{ route('get-user-notification') }}" class="nav-top {{ Route::is('get-user-notification') ? 'nav-top-active' : '' }} "><span class="iconify icon" data-icon="clarity:bell-line" data-inline="false"></span></a> 
                    <a href="{{ route('get-user-logout') }}" class="nav-top"><span class="iconify icon" data-icon="la:power-off" data-inline="false"></span></a> 
                </div>
                @yield('content')
            </div>
        </div>
    </div>

    <!-- toastr script -->
    <script>
        @if(Session::has('message'))
            var type = "{{ Session::get('alert-type', 'info') }}";
            switch(type){
            case 'info':
                toastr.info("{{ Session::get('message') }}");
                break;

            case 'warning':
                toastr.warning("{{ Session::get('message') }}");
                break;

            case 'success':
                toastr.success("{{ Session::get('message') }}");
                break;

            case 'error':
                toastr.error("{{ Session::get('message') }}");
                break;
            }
        @endif
        toastr.options.progressBar = true;
    </script>
    <!-- end toastr -->

</body>
</html>