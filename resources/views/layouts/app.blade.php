<x-laravel-ui-adminlte::adminlte-layout>

    <link href="{{ asset('assets/vendor/fontawesome-free-6.1.1-web/css/all.min.css') }}" rel="stylesheet" type="text/css">

    <link type="text/css" href="{{ asset('assets/vendor/datatables1.12/datatables.min.css') }}" rel="stylesheet">
    <link type="text/css" href="{{ asset('assets/css/datatables-custom.min.css') }}" rel="stylesheet">

    <body class="hold-transition sidebar-mini layout-fixed">
        <div class="wrapper">
            <!-- Main Header -->
            <nav class="main-header navbar navbar-expand navbar-white navbar-light">
                <!-- Left navbar links -->
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                    </li>
                </ul>

                <ul class="navbar-nav ml-auto ">
                    <li class="nav-item dropdown user-menu">
                        <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">
                            <img src="https://assets.infyom.com/logo/blue_logo_150x150.png" class="user-image img-circle elevation-2" alt="User Image">
                            <span class="d-none d-md-inline">{{ Auth::user()->name }}</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                            <!-- User image -->
                            <li class="user-header bg-primary">
                                <img src="https://assets.infyom.com/logo/blue_logo_150x150.png" class="img-circle elevation-2" alt="User Image">
                                <p>
                                    {{ Auth::user()->name }}
                                    <small>Member since {{ Auth::user()->created_at->format('M. Y') }}</small>
                                </p>
                            </li>
                            <!-- Menu Footer-->
                            <li class="user-footer">
                                <a href="#" class="btn btn-default btn-flat">Profile</a>
                                <a href="#" class="btn btn-default btn-flat float-right" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    Sign out
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </li>
                        </ul>
                    </li>
                </ul>
            </nav>

            <!-- Left side column. contains the logo and sidebar -->
            @include('layouts.sidebar')



            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper mt-3">
                {{-- <div class="mb-5"></div> --}}
                @yield('content')
            </div>

            <!-- Main Footer -->
            <footer class="main-footer">
                <div class="float-right d-none d-sm-block">
                    <b>Version</b> 3.1.0
                </div>
                <strong>Copyright &copy; 2014-2023 <a href="https://adminlte.io">AdminLTE.io</a>.</strong> All rights
                reserved.
            </footer>
        </div>



        <script type="text/javascript" src="{{ asset('assets/vendor/jquery/jquery.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('assets/vendor/datatables1.12/datatables.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('assets/vendor/cleave.js/dist/cleave.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('assets/js/cleave.js-custom.min.js') }}"></script>
    </body>

</x-laravel-ui-adminlte::adminlte-layout>
