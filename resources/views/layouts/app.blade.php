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

    <!-- Styles -->
    <link href="{{ asset('css/bootstrap/css/bootstrap.css') }}" rel="stylesheet">

    <!-- Toastr -->
    <link rel="stylesheet" href="{{asset('paneladmin/plugins/toastr/toastr.min.css')}}">

    {{-- Tailwind CSS --}}
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    @stack('style')
    @stack('script-head-lib')
</head>
<body>
    <div>
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container">
              <a class="navbar-brand" href="{{url('/')}}">{{__($setting->appname)}}</a>
              <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
              </button>
              <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mb-2 mb-lg-0">
                  @auth
                  <li class="nav-item">
                    <a href="{{route('user.index')}}" class="nav-link"> @lang('Dashboard') </a>
                  </li>
                  <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                      {{__(auth()->user()->name)}}
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                      <li><a class="dropdown-item" href="{{route('user.deposit.set.amount')}}">{{__('Deposit Now')}}</a></li>
                      <li><a class="dropdown-item" href="{{route('user.deposit.history')}}">{{__('Deposit History')}}</a></li>
                      <li><a class="dropdown-item" href="{{route('user.deposit.selector')}}">{{__('Update Your Payment Info')}}</a></li>
                      <li><hr class="dropdown-divider"></li>
                      <li>
                        <form action="{{route('logout')}}" method="post">
                          @csrf
                          <li>
                            <button type="submit" class="dropdown-item"> @lang('Logout') </button>
                          </li>
                        </form>
                      </li>
                    </ul>
                  </li>
                  @else 
                    <li class="nav-item">
                      <a href="{{route('login')}}" class="nav-link"> {{__("Login")}} </a>
                    </li>
                    <li class="nav-item">
                      <a href="{{route('register')}}" class="nav-link"> {{__("Register")}} </a>
                    </li>
                  @endauth
                </ul>
              </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>
</body>

<script src="{{asset('js/jquery.min.js')}}"></script>

<script src="{{ asset('js/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- Toastr -->
<script src="{{asset('paneladmin/plugins/toastr/toastr.min.js')}}"></script>


@stack('script')
@include('partials.toaster')
</html>
