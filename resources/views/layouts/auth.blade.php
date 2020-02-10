<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title>Sign In | {{ config('app.name') }}</title>
    <!-- Favicon-->
    <link rel="icon" href="../../favicon.ico" type="image/x-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&subset=latin,cyrillic-ext" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">

    <!-- Bootstrap Core Css -->
    <link href="{{ asset('adminbsb/plugins/bootstrap/css/bootstrap.css') }}" rel="stylesheet">

    <!-- Waves Effect Css -->
    <link href="{{ asset('adminbsb/plugins/node-waves/waves.css') }}" rel="stylesheet" />

    <!-- Animation Css -->
    <link href="{{ asset('adminbsb/plugins/animate-css/animate.css') }}" rel="stylesheet" />

	<!-- Custom Css -->
    <link href="{{ asset('adminbsb/css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">

    <!-- AdminBSB Themes. You can choose a theme from css/themes instead of get all themes -->
    <link href="{{ asset('adminbsb/css/themes/all-themes.css') }}" rel="stylesheet" />
</head>

<body class="login-page">
    <div class="login-box">
        <div class="logo">
            <a href="javascript:void(0);">Lely<b>Salon</b></a>
            <small>Autentikasi untuk Admin & Kasir</small>
        </div>
        <div class="card">
            <div class="body">
                @yield('content')
            </div>
        </div>
    </div>

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

    <!-- Waves Effect Plugin Js -->
    <script src="{{ asset('adminbsb/plugins/node-waves/waves.js') }}"></script>

    <!-- Custom Js -->
    <script src="{{ asset('adminbsb/js/admin.js') }}"></script>

    <!-- Demo Js -->
	<script src="{{ asset('adminbsb/js/demo.js') }}"></script>
	
</body>

</html>