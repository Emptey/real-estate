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
    <!-- END JS -->

    <title>@yield('title')</title>
</head>
<body>
    <!-- stylesheet -->
    <style>
        .table {
        width: 100%;
        max-width: 100%;
        margin-bottom: 1rem;
        }

        .table th,
        .table td {
        padding: 0.75rem;
        vertical-align: top;
        border-top: 1px solid #eceeef;
        }

        .table thead th {
        vertical-align: bottom;
        border-bottom: 2px solid #eceeef;
        }

        .table tbody + tbody {
        border-top: 2px solid #eceeef;
        }

        .table .table {
        background-color: #fff;
        }

        .table-sm th,
        .table-sm td {
        padding: 0.3rem;
        }

        .table-bordered {
        border: 1px solid #eceeef;
        }

        .table-bordered th,
        .table-bordered td {
        border: 1px solid #eceeef;
        }

        .table-bordered thead th,
        .table-bordered thead td {
        border-bottom-width: 2px;
        }

        .table-striped tbody tr:nth-of-type(odd) {
        background-color: rgba(0, 0, 0, 0.05);
        }

        .table-hover tbody tr:hover {
        background-color: rgba(0, 0, 0, 0.075);
        }

        .table-active,
        .table-active > th,
        .table-active > td {
        background-color: rgba(0, 0, 0, 0.075);
        }

        .table-hover .table-active:hover {
        background-color: rgba(0, 0, 0, 0.075);
        }

        .table-hover .table-active:hover > td,
        .table-hover .table-active:hover > th {
        background-color: rgba(0, 0, 0, 0.075);
        }

        .table-success,
        .table-success > th,
        .table-success > td {
        background-color: #dff0d8;
        }

        .table-hover .table-success:hover {
        background-color: #d0e9c6;
        }

        .table-hover .table-success:hover > td,
        .table-hover .table-success:hover > th {
        background-color: #d0e9c6;
        }

        .table-info,
        .table-info > th,
        .table-info > td {
        background-color: #d9edf7;
        }

        .table-hover .table-info:hover {
        background-color: #c4e3f3;
        }

        .table-hover .table-info:hover > td,
        .table-hover .table-info:hover > th {
        background-color: #c4e3f3;
        }

        .table-warning,
        .table-warning > th,
        .table-warning > td {
        background-color: #fcf8e3;
        }

        .table-hover .table-warning:hover {
        background-color: #faf2cc;
        }

        .table-hover .table-warning:hover > td,
        .table-hover .table-warning:hover > th {
        background-color: #faf2cc;
        }

        .table-danger,
        .table-danger > th,
        .table-danger > td {
        background-color: #f2dede;
        }

        .table-hover .table-danger:hover {
        background-color: #ebcccc;
        }

        .table-hover .table-danger:hover > td,
        .table-hover .table-danger:hover > th {
        background-color: #ebcccc;
        }

        .thead-inverse th {
        color: #fff;
        background-color: #292b2c;
        }

        .thead-default th {
        color: #464a4c;
        background-color: #eceeef;
        }

        .table-inverse {
        color: #fff;
        background-color: #292b2c;
        }

        .table-inverse th,
        .table-inverse td,
        .table-inverse thead th {
        border-color: #fff;
        }

        .table-inverse.table-bordered {
        border: 0;
        }

        .table-responsive {
        display: block;
        width: 100%;
        overflow-x: auto;
        -ms-overflow-style: -ms-autohiding-scrollbar;
        }

        .table-responsive.table-bordered {
        border: 0;
        }

        .text-center {
            text-align: center;
        }

        table {
            border-collapse: collapse;
        }

        table>thead>tr>th {
            background-color: #2774AE;
            color: #000;
            border: none;
        }
    </style>
    <!-- end style -->
    
    @yield('content')
           
</body>
</html>