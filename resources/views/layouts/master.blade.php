<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>MTSC Inventory</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ asset('assets/bower_components/bootstrap/dist/css/bootstrap.min.css ')}}">
    <link rel="stylesheet" href="{{ asset('assets/bower_components/font-awesome/css/font-awesome.min.css')}} ">
    <link rel="stylesheet" href="{{ asset('assets/bower_components/Ionicons/css/ionicons.min.css')}} ">
    <link rel="stylesheet" href="{{ asset('assets/bootstrap/css/bootstrap.min.css') }}">

    <!-- SweetAlert2 -->
    <script src="{{ asset('assets/sweetalert2/sweetalert2.min.js') }}"></script>
    <link href="{{ asset('assets/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet">
    <link rel="icon" type="image/png" sizes="96x96" href="{{asset('assets/img/inven12.jpg')}}">


    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('assets/dist/css/AdminLTE.min.css')}} ">
    <link rel="stylesheet" href="{{ asset('assets/dist/css/skins/skin-purple-light.min.css')}} ">

    @yield('top')

    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>

<body class="hold-transition skin-purple-light sidebar-mini">
    <div class="wrapper">

        <header class="main-header">

            <!-- Logo -->
            <a href="index2.html" class="logo">
                <span class="logo-mini"><img src="{{ asset('assets/img/mtsc-logo-rem.png') }}" class="MTSC Logo-image" style="height:40px;" alt="MTSC Logo Image"></span>
                <span class="logo-lg"><img src="{{ asset('assets/img/mtsc-logo-rem.png') }}" class="MTSC Logo-image" style="height:40px;" alt="MTSC Logo Image"> MTSC Singapore</span>
            </a>

            <!-- Header Navbar -->
            <nav class="navbar navbar-static-top" role="navigation">
                <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
                    <span class="sr-only">Toggle navigation</span>
                </a>
                <!-- Navbar Right Menu -->
                <div class="navbar-custom-menu">
                    <ul class="nav navbar-nav">
                        <!-- User Account Menu -->
                        <li class="dropdown user user-menu">
                            <!-- Menu Toggle Button -->
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <img src="{{ asset('assets/img/user-profile.png') }}" class="user-image" alt="User Image">
                                <!-- hidden-xs hides the username on small devices so only the image appears. -->
                                <span class="hidden-xs">{{ \Auth::user()->name  }}</span>
                            </a>
                            <ul class="dropdown-menu">
                                <li class="user-header">
                                    <img src="{{ asset('assets/img/user-profile.png') }} " class="img-circle" alt="User Image">

                                    <p>
                                        {{ \Auth::user()->name  }}
                                        <small>{{ \Auth::user()->email  }}</small>
                                    </p>
                                </li>

                                <!-- Menu Footer-->
                                <li class="user-footer">
                                    {{--<div class="pull-left">--}}
                                    {{--<a href="#" class="btn btn-default btn-flat">Profile</a>--}}
                                    {{--</div>--}}
                                    <div class="pull-right">
                                        <a class="btn btn-danger btn-flat" href="{{ route('logout') }}"
                                            onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                            {{ __('Logout') }}
                                        </a>

                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            @csrf
                                        </form>
                                    </div>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>
        <!-- Left side column. contains the logo and sidebar -->
        @include('layouts.sidebar')

        <div class="content-wrapper">
            <section class="content container-fluid">

                @yield('content')


            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->

        <!-- Main Footer -->
        <footer class="main-footer">
            <!-- To the right -->
            <div class="pull-right hidden-xs">
                <!-- Reserved -->
            </div>
            <!-- Default to the left -->
            <?php $date = date('Y') ?>
            <strong>&copy; {{$date}} - MTSC Inventory Management System </strong>
        </footer>
        <div class="control-sidebar-bg"></div>
    </div>

    <!-- jQuery 3 -->
    <script src="{{  asset('assets/bower_components/jquery/dist/jquery.min.js') }} "></script>
    <!-- Bootstrap 3.3.7 -->
    <script src="{{  asset('assets/bower_components/bootstrap/dist/js/bootstrap.min.js') }} "></script>
    <!-- AdminLTE App -->
    <script src="{{  asset('assets/dist/js/adminlte.min.js') }}"></script>
    <!-- 1000hz Bootstrap Validator -->
    <script src="{{ asset('assets/plugins/validator/validator.min.js') }}"></script>
    @yield('bot')
</body>

</html>