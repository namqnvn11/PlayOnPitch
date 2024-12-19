<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>PlayOnPitch | Admin</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{  asset('assets/templates/adminlte3/plugins/fontawesome-free/css/all.min.css' ) }}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="{{  asset('assets/templates/adminlte3/dist/css/ionicons.min.css' ) }}">
    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet" href="{{  asset('assets/templates/adminlte3/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css' ) }}">
    <!-- iCheck -->
    <link rel="stylesheet" href="{{  asset('assets/templates/adminlte3/plugins/icheck-bootstrap/icheck-bootstrap.min.css' ) }}">
    <!-- JQVMap -->
    <link rel="stylesheet" href="{{  asset('assets/templates/adminlte3/plugins/jqvmap/jqvmap.min.css' ) }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{  asset('assets/templates/adminlte3/dist/css/adminlte.min.css' ) }}">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="{{  asset('assets/templates/adminlte3/plugins/overlayScrollbars/css/OverlayScrollbars.min.css' ) }}">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="{{  asset('assets/templates/adminlte3/plugins/daterangepicker/daterangepicker.css' ) }}">
    <!-- summernote -->
    <link rel="stylesheet" href="{{  asset('assets/templates/adminlte3/plugins/summernote/summernote-bs4.min.css' ) }}">

    <link rel="stylesheet" href="{{  asset('assets/libraries/toastr/toastr.min.css' ) }}">
    <link rel="stylesheet" href="{{  asset('css/custom.css?v='.config('constant.app_version') ) }}">
    <link rel="stylesheet" href="{{  asset('css/admin/admin.css?v='.config('constant.app_version') ) }}">


    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar elevation-4 bg-green-900">
        <!-- Brand Logo -->
        <a href="/" class="brand-link">
            <img src="{{  asset('img/logo.png' ) }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
            <span class="brand-text font-weight-bold text-gray-300">PlayOnPitch</span>
        </a>

        <!-- Sidebar -->
        <div class="sidebar">


            <!-- Sidebar Menu -->
            <nav class="mt-2">
                @include('layouts.adminlte3.menu')
            </nav>
            <!-- /.sidebar-menu -->
        </div>
        <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        @yield('content')
    </div>

    {{--    @include('layouts.adminlte3.footer')--}}

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
        <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="{{  asset('assets/templates/adminlte3/plugins/jquery/jquery.min.js' ) }}"></script>
<!-- jQuery UI 1.11.4 -->
<script src="{{  asset('assets/templates/adminlte3/plugins/jquery-ui/jquery-ui.min.js' ) }}"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->

<!-- Bootstrap 4 -->
<script src="{{  asset('assets/templates/adminlte3/plugins/bootstrap/js/bootstrap.bundle.min.js' ) }}"></script>
<!-- ChartJS -->
<!-- Sparkline -->
<script src="{{  asset('assets/templates/adminlte3/plugins/sparklines/sparkline.js' ) }}"></script>
<!-- JQVMap -->
<script src="{{  asset('assets/templates/adminlte3/plugins/jqvmap/jquery.vmap.min.js' ) }}"></script>
<script src="{{  asset('assets/templates/adminlte3/plugins/jqvmap/maps/jquery.vmap.usa.js' ) }}"></script>
<!-- jQuery Knob Chart -->
<script src="{{  asset('assets/templates/adminlte3/plugins/jquery-knob/jquery.knob.min.js' ) }}"></script>
<!-- daterangepicker -->
<script src="{{  asset('assets/templates/adminlte3/plugins/moment/moment.min.js' ) }}"></script>
<script src="{{  asset('assets/templates/adminlte3/plugins/daterangepicker/daterangepicker.js' ) }}"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="{{  asset('assets/templates/adminlte3/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js' ) }}"></script>
<!-- Summernote -->
<script src="{{  asset('assets/templates/adminlte3/plugins/summernote/summernote-bs4.min.js' ) }}"></script>
<!-- overlayScrollbars -->
<script src="{{  asset('assets/templates/adminlte3/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js' ) }}"></script>
<!-- AdminLTE App -->
<script src="{{  asset('assets/templates/adminlte3/dist/js/adminlte.js' ) }}"></script>
<script src="{{  asset('assets/libraries/toastr/toastr.min.js' ) }}"></script>
<script src="{{  asset('js/notification.js' ) }}"></script>
<script src="{{  asset('js/common.js' ) }}"></script>
<!-- AdminLTE for demo purposes -->

@yield('pagescript')

</body>
</html>
