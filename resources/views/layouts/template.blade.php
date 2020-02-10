<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title>@yield('title')</title>

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Favicon-->
    <link rel="icon" href="{{ asset('adminbsb/favicon.png') }}" type="image/x-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&subset=latin,cyrillic-ext" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">

    <!-- Bootstrap Core Css -->
    <link href="{{ asset('adminbsb/plugins/bootstrap/css/bootstrap.css') }}" rel="stylesheet">

    <!-- Waves Effect Css -->
    <link href="{{ asset('adminbsb/plugins/node-waves/waves.css') }}" rel="stylesheet" />

    <!-- Animation Css -->
    <link href="{{ asset('adminbsb/plugins/animate-css/animate.css') }}" rel="stylesheet" />

    <!-- Bootstrap Select Css -->
    <link href="{{ asset('adminbsb/plugins/bootstrap-select/css/bootstrap-select.css') }}" rel="stylesheet">

    @yield('head-scripts-sweetalert')
    @yield('head-scripts-table')
    @yield('head-scripts-form')

    <!-- Custom Css -->
    <link href="{{ asset('adminbsb/css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">

    <!-- AdminBSB Themes. You can choose a theme from css/themes instead of get all themes -->
    <link href="{{ asset('adminbsb/css/themes/all-themes.css') }}" rel="stylesheet" />

</head>

<body class="theme-pink">
    <!-- Page Loader -->
    <div class="page-loader-wrapper">
        <div class="loader">
            <div class="preloader">
                <div class="spinner-layer pl-red">
                    <div class="circle-clipper left">
                        <div class="circle"></div>
                    </div>
                    <div class="circle-clipper right">
                        <div class="circle"></div>
                    </div>
                </div>
            </div>
            <p>Mohon Tunggu Sebentar..</p>
        </div>
    </div>
    <!-- #END# Page Loader -->
    <!-- Overlay For Sidebars -->
    <div class="overlay"></div>
    <!-- #END# Overlay For Sidebars -->

    <!-- Top Bar -->
    @include('layouts.topbar')
    <!-- #Top Bar -->
    <section>
        <!-- Left Sidebar -->
        @include('layouts.sidebar')
        <!-- #END# Left Sidebar -->
    </section>

    <section class="content">
        <div class="container-fluid"  id="app">
            @yield('content')
        </div>
    </section>

    <script src="{{ asset('js/app.js') }}"></script>

    <!-- Jquery Core Js -->
    <script src="{{ asset('adminbsb/plugins/jquery/jquery.min.js') }}"></script>

    <!-- Axios Core Js -->
    <script src="{{ asset('js/axios.min.js') }}"></script>

    <!-- Bootstrap Core Js -->
    <script src="{{ asset('adminbsb/plugins/bootstrap/js/bootstrap.js') }}"></script>

    <!-- Slimscroll Plugin Js -->
    <script src="{{ asset('adminbsb/plugins/jquery-slimscroll/jquery.slimscroll.js') }}"></script>

    <!-- Bootstrap Notify Plugin Js -->
    <script src="{{ asset('adminbsb/plugins/bootstrap-notify/bootstrap-notify.js') }}"></script>

    <!-- Select Plugin Js -->
    <script src="{{ asset('adminbsb/plugins/bootstrap-select/js/bootstrap-select.js') }}"></script>

    <!-- Waves Effect Plugin Js -->
    <script src="{{ asset('adminbsb/plugins/node-waves/waves.js') }}"></script>

    <!-- Custom Js -->
    <script src="{{ asset('adminbsb/js/admin.js') }}"></script>

    <!-- Demo Js -->
    <script src="{{ asset('adminbsb/js/demo.js') }}"></script>

    @yield('end-scripts-sweetalert')
    @yield('end-scripts-table')
    @yield('end-scripts-form')
    @yield('end-scripts-extra')
    @stack('end-scripts')


</body>

</html>
