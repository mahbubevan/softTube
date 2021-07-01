@extends('admin.layouts.master')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-indigo-500 text-white">
                    <h4 class="card-title"> @lang('Email Method') </h4>
                </div>
                <form action="{{route('admin.setting.email.configure')}}" method="post">
                    @csrf
                    <div class="card-body">
                        <div class="row">
                            <div class="form-group col-md-12">
                                <label for="email_method"> @lang('Select Method') </label>
                                <select name="email_method" id="email_method" class="form-control">
                                    <option value="php" @if (@$setting->email_config->method =='php')
                                        selected
                                    @endif > @lang('PHP Mail') </option>
                                    <option value="smtp" @if(@$setting->email_config->method == 'smtp') selected @endif>@lang('SMTP')</option>
                                </select>
                            </div>
                        </div>

                        <div class="row @if(@$setting->email_config->method != 'smtp') d-none @endif" id="smtp">
                            <div class="col-md-12 mb-3">
                                <p class="font-bold"> @lang('SMTP Configuration') </p>
                            </div>
                            <div class="form-group col-md-4">
                                <label class="font-weight-bold">@lang('Host') </label>
                                <input type="text" class="form-control" placeholder="@lang('Required')" name="host" value="{{ $setting->email_config->host ?? '' }}"/>
                            </div>
                            <div class="form-group col-md-4">
                                <label class="font-weight-bold">@lang('Port') </label>
                                <input type="text" class="form-control" placeholder="@lang('Required')" name="port" value="{{ $setting->email_config->port ?? '' }}"/>
                            </div>
                            <div class="form-group col-md-4">
                                <label class="font-weight-bold">@lang('Username') </label>
                                <input type="text" class="form-control" placeholder="@lang('Required')" name="username" value="{{ $setting->email_config->username ?? '' }}"/>
                            </div>
                            <div class="form-group col-md-4">
                                <label class="font-weight-bold">@lang('Password') </label>
                                <input type="text" class="form-control" placeholder="@lang('Required')" name="password" value="{{ $setting->email_config->password ?? '' }}"/>
                            </div>
                            <div class="form-group col-md-4">
                                <label class="font-weight-bold">@lang('Encryption')</label>
                                <select class="form-control" name="enc">
                                    <option @if (@$setting->email_config->enc == "ssl")
                                        selected
                                    @endif value="ssl">@lang('SSL')</option>
                                    <option @if (@$setting->email_config->enc == "tls")
                                        selected
                                    @endif value="tls">@lang('TLS')</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button class="btn btn-sm float-right bg-indigo-500 hover:bg-indigo-700 text-white" type="submit"> @lang('Update') </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-indigo-500 text-white">
                    <h4 class="card-title"> @lang('Application Email') </h4>
                </div>
                <form action="{{route('admin.setting.email.template')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        <div class="row">
                            <div class="form-group col-md-12">
                                <textarea class="form-control textarea" name="templates" cols="30">{{@$setting->email_template}}</textarea>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button class="btn btn-sm float-right bg-indigo-500 hover:bg-indigo-700 text-white" type="submit"> @lang('Update') </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
@push('script')
    <script>
        $("#email_method").on('change',function(){
            if ($(this).val()=='smtp') {
                $("#smtp").removeClass("d-none")
            }else{
                $("#smtp").addClass("d-none")
            }
        })
    </script>
@endpush
