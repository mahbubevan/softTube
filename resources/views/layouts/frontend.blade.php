<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <!-- Line Awesome Icons -->
    <link rel="stylesheet" href="{{asset('css/lineawesome/css/line-awesome.min.css')}}">
    <!-- Styles -->
    <link href="{{ asset('css/bootstrap/css/bootstrap.css') }}" rel="stylesheet">

    <!-- Toastr -->
    <link rel="stylesheet" href="{{asset('paneladmin/plugins/toastr/toastr.min.css')}}">
    <!-- Select2 -->
    <link rel="stylesheet" href="{{asset('paneladmin/plugins/select2/css/select2.min.css')}}">
    <link rel="stylesheet" href="{{asset('paneladmin/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')}}">

    {{-- Tailwind CSS --}}
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    @stack('style')
    @stack('script-head-lib')
</head>
<body>
    <div>
        <main class="py-4">
            @yield('content')
        </main>
    </div>
</body>

<script src="{{asset('js/jquery.min.js')}}"></script>

<script src="{{ asset('js/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- Select2 -->
<script src="{{asset('paneladmin/plugins/select2/js/select2.full.min.js')}}"></script>
<!-- Toastr -->
<script src="{{asset('paneladmin/plugins/toastr/toastr.min.js')}}"></script>

<script>
  $(function () {
    $('[data-toggle="tooltip"]').tooltip()
  })
</script>
@stack('script')
@include('partials.toaster')
</html>
