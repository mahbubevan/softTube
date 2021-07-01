@extends('admin.layouts.app')
@section('content')
<div class="login-box">
    <div class="login-logo">
      <a href="{{route('admin.login')}}"> {{__($appName)}} </a>
    </div>
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">
      <p class="login-box-msg"> {{__("Sign In & Explore")}} </p>

      <form action="{{route('admin.login')}}" method="post">
        @csrf
        <div class="input-group mb-3">
          <input type="text" name="username" class="form-control" placeholder="@lang('Username')">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" name="password" class="form-control" placeholder="@lang('Password')">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <!-- /.col -->
          <div class="col-4">
            <button type="submit" class="btn btn-primary btn-block"> @lang('Sign In') </button>
          </div>
          <!-- /.col -->
        </div>
      </form>

      <p class="mb-1">
        <a href="{{route('admin.password.request')}}"> {{__("I forgot my password")}} </a>
      </p>
    </div>
    <!-- /.login-card-body -->
  </div>
</div>
@endsection
