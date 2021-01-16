<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <!-- stylesheet -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" 
        integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <link rel="stylesheet" href="{{ asset('assets/css/admin_custom.css') }}" />
    <!-- end stylesheet -->

    <!-- google font -->
    <link rel="preconnect" href="https://fonts.gstatic.com" />
    <link href="https://fonts.googleapis.com/css2?family=Archivo:wght@400;500;600;700&display=swap" rel="stylesheet" />
    <!-- end google font -->

    <!-- font-awesome kit -->
    <script src="https://kit.fontawesome.com/f5c784c3df.js" crossorigin="anonymous"></script>
    <!-- end font awesome -->

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
    
    <div class="container-fluid" style="height:100%; background-color:white">
        <div class="row" style="height:100%">
            <!-- menu -->
            <div class="col-md-2 col-lg-2 col-sm-12 nav-container fixed-top animate__animated animate__fadeIn animate__fast" style="height: 100% !important">
                <x-admin-navigation />
            </div>
            <!-- end menu -->

            <!-- content -->
            <div class="col-md-9 col-lg-9 col-sm-12 parent-wrapper animate__animated animate__fadeIn animate__delay-1s" style="margin-left: 20%">
                <div class="container-fluid content-wrapper">
                    @yield('content')
                </div>
            </div>
            <!-- end content -->

        </div>
    </div>
    
    <!-- js -->
    @yield('javascript')
    <!-- end js -->

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