<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title')</title>

    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset('logountan.jpeg') }}">
    <link rel="stylesheet" type="text/css" href="assets/libs/toastr/build/toastr.min.css">

    <!-- Bootstrap Css -->
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" id="bootstrap-style" rel="stylesheet" type="text/css" />
        <!-- Icons Css -->
    <link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
        <!-- App Css-->
    <link href="{{ asset('assets/css/app.min.css') }}" id="app-style" rel="stylesheet" type="text/css" />


    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10">

    @stack('css-plugins')
</head>
<body data-topbar="dark">

    @yield('content')

    @stack('javascript-plugins')
    <!-- JAVASCRIPT -->
    <script src="{{ asset('assets/libs/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/libs/metismenu/metisMenu.min.js') }}"></script>
    <script src="{{ asset('assets/libs/simplebar/simplebar.min.js') }}"></script>
    <script src="{{ asset('assets/libs/node-waves/waves.min.js') }}"></script>

        <!-- toastr plugin -->
    <script src="{{ asset('assets/libs/toastr/build/toastr.min.js') }}"></script>

        <!-- toastr init -->
    <script src="{{ asset('assets/js/pages/toastr.init.js') }}"></script>

    <script src="{{ asset('assets/js/app.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/clipboard.js/2.0.8/clipboard.min.js"></script>

    <!-- fontawesome icons init -->
    <script src="{{ asset('assets/js/pages/fontawesome.init.js') }}"></script>

</body>
</html>