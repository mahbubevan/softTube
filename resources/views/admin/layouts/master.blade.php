<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge">

  <title>{{ __($setting->appname) }}</title>
  <link rel="icon" href="{{asset(path()['favicon']['path'].'/'.$setting->favicon)}}" type="image/gif" sizes="16x16">
 <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="{{asset('paneladmin/plugins/fontawesome-free/css/all.min.css')}}">

  <!-- Line Awesome Icons -->
  <link rel="stylesheet" href="{{asset('css/lineawesome/css/line-awesome.min.css')}}">

  <!-- IonIcons -->
  <link rel="stylesheet" href="http://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Select2 -->
    <link rel="stylesheet" href="{{asset('paneladmin/plugins/select2/css/select2.min.css')}}">
    <link rel="stylesheet" href="{{asset('paneladmin/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')}}">
  <!-- Toastr -->
  <link rel="stylesheet" href="{{asset('paneladmin/plugins/toastr/toastr.min.css')}}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{asset('paneladmin/dist/css/adminlte.css')}}">

    {{-- Bootstrap Toggle CSS --}}
    <link rel="stylesheet" href="{{asset('paneladmin/plugins/toggle/bootstrap-toggle.min.css')}}">
    <!-- Tailwind CSS -->
  <link rel="stylesheet" href="{{asset('css/app.css')}}">

  <!-- summernote -->
  <link rel="stylesheet" href="{{asset('paneladmin/plugins/summernote/summernote-bs4.css')}}">

  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
  @stack('style')
</head>
<!--
BODY TAG OPTIONS:
=================
Apply one or more of the following classes to to the body tag
to get the desired effect
|---------------------------------------------------------|
|LAYOUT OPTIONS | sidebar-collapse                        |
|               | sidebar-mini                            |
|---------------------------------------------------------|
-->
<body class="hold-transition sidebar-mini">
<div class="wrapper">
  <!-- Navbar -->
  @include('admin.partials.navbar')
  <!-- /.navbar -->
  <!-- Main Sidebar Container -->
  @include('admin.partials.sidebar')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header - Breadcrumb (Page header) -->
        @include('admin.partials.breadcrumb')
    <!-- /.content-header -->
    <!-- Main content -->
    <div class="content">
      @yield('content')
      <!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->

  <!-- Main Footer -->
  @include('admin.partials.footer')
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->

<!-- jQuery -->
<script src="{{asset('paneladmin/plugins/jquery/jquery.min.js')}}"></script>
<!-- Bootstrap -->
<script src="{{asset('paneladmin/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<!-- Select2 -->
<script src="{{asset('paneladmin/plugins/select2/js/select2.full.min.js')}}"></script>
<!-- Toastr -->
<script src="{{asset('paneladmin/plugins/toastr/toastr.min.js')}}"></script>
<!-- AdminLTE -->
<script src="{{asset('paneladmin/dist/js/adminlte.js')}}"></script>

{{-- Bootstrap Toggle Script --}}
<script src="{{asset('paneladmin/plugins/toggle/bootstrap-toggle.min.js')}}"></script>

<!-- OPTIONAL SCRIPTS -->
<script src="{{asset('paneladmin/plugins/chart.js/Chart.min.js')}}"></script>

<!-- Summernote -->
<script src="{{asset('paneladmin/plugins/summernote/summernote-bs4.min.js')}}"></script>
<script>
  $(function () {
    $('.textarea').summernote()
  })
</script>

<script>
  $(function () {
    $('[data-toggle="tooltip"]').tooltip()
  })
</script>

@stack('script')

@include('partials.toaster')
</body>
</html>
