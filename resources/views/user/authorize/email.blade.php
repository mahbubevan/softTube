@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-indigo-500 text-white">
                    <h4> @lang('Verify Your Email Address') </h4>
                </div>
                <form action="" method="post">
                    @csrf
                    <div class="card-body">
                        <div class="row">
                            <div class="form-group col-md-12">
                                <label for="code"> @lang('Verification Code') </label>
                                <input type="text" class="form-control" name="code">
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn bg-indigo-500 hover:bg-indigo-700 text-white"> @lang('Verify') </button>
                        <a href="{{route('user.authorize.resend')}}"> @lang('Resend Code') </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection