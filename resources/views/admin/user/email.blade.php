@extends('admin.layouts.master')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-indigo-500 text-white">
                    <h4 class="card-title"> @lang('Application Email') </h4>
                </div>
                <form action="{{route('admin.user.email.send')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        <div class="row">
                            <div class="form-group col-md-12">
                                <label for="subject" class="font-bold"> @lang('Subject') </label>
                                <input id="subject" class="form-control" name="subject" placeholder="@lang('Required')"/>
                            </div>
                            <div class="form-group col-md-12">
                                <label for="message" class="font-bold"> @lang('Message') </label>
                                <textarea id="message" class="form-control" name="message" cols="30" rows="5" placeholder="@lang('Required')"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button class="btn btn-sm float-right bg-indigo-500 hover:bg-indigo-700 text-white" type="submit"> @lang('Send Mail') </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
