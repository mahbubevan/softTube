@extends('admin.layouts.master')
@section('content')
<div class="container-fluid">
    <form action="{{route('admin.setting.update')}}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="form-row">
                            <div class="form-group col">
                                <label for="name">{{__('App Name')}} </label>
                                <input type="text" class="form-control" name="name" id="name" value="{{$gs->appname??""}}" placeholder="{{__('Required')}}">
                            </div>
                            <div class="form-group col">
                                <label for="email">{{__('Email Address')}}</label>
                                <input type="email" class="form-control" name="email" id="email" value="{{$gs->email??""}}" placeholder="{{__('Required')}}">
                            </div>
                            <div class="form-group col">
                                <label for="currency">{{__('Currency')}}</label>
                                <input type="text" class="form-control" name="currency" value="{{$gs->currency??""}}" id="currency" placeholder="{{__('Required')}}">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-6">
                                <label for="registration" class="d-block">{{__('Registration')}}</label>
                                <input type="checkbox" data-width="100%" data-onstyle="success" data-offstyle="danger" data-toggle="toggle" data-on="@lang('Enable')" data-off="@lang('Disabled')" name="registration" @if($gs->registration) checked @endif>
                            </div>
                            <div class="form-group col-6">
                                <label for="ev" class="d-block">{{__('Email Verification')}}</label>
                                <input type="checkbox" data-width="100%" data-onstyle="success" data-offstyle="danger" data-toggle="toggle" data-on="@lang('Enable')" data-off="@lang('Disabled')" name="ev" @if($gs->ev) checked @endif>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-6">
                                <div class="card text-center">
                                    <div class="card-header bg-dark">
                                        <h4 class="card-title"> {{__('App Logo')}} </h4>
                                    </div>
                                    <div class="card-body">
                                        <div class="logoProfilePreview logoFav">
                                            <img src="{{asset(path()['logo']['path'].'/'.$gs->logo)}}" alt="@lang('logo')" class="img-fluid">
                                        </div>
                                    </div>
                                    <div class="card-footer">
                                        <input id="logo" type="file" class="form-control d-none" name="logo">
                                        <label for="logo" class="btn btn-sm btn-block btn-info">
                                                <i class="fas fa-upload"></i>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-6">
                                <div class="card text-center">
                                    <div class="card-header bg-dark">
                                        <h4 class="card-title"> {{__('App favicon')}} </h4>
                                    </div>
                                    <div class="card-body">
                                        <div class="faviconProfilePreview logoFav">
                                            <img src="{{asset(path()['favicon']['path'].'/'.$gs->favicon)}}" alt="@lang('favicon')" class="img-fluid">
                                        </div>
                                    </div>
                                    <div class="card-footer">
                                        <input id="favicon" type="file" class="form-control d-none" name="favicon">
                                        <label for="favicon" class="btn btn-sm btn-block btn-info">
                                                <i class="fas fa-upload"></i>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-12">
                                <button type="submit" class="btn btn-sm bg-indigo-500 hover:bg-indigo-700 text-white float-right">{{__('Update')}}</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection

@push('script')

    <script>
        "use strict"
          function proPicURLlogo(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    var preview = $(input).parents().parents().find('.logoProfilePreview');
                    $(preview).html(`
                    <img class="img-fluid"
                         src="${e.target.result}"
                         alt="@lang('Logo')">
                    `);
                    $(preview).addClass('has-image');
                    $(preview).hide();
                    $(preview).fadeIn(650);
                }
                reader.readAsDataURL(input.files[0]);
            }
          }
          $("#logo").on('change',function() {
            proPicURLlogo(this);
          });


          function proPicURLfavicon(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    var preview = $(input).parents().parents().find('.faviconProfilePreview');
                    $(preview).html(`
                    <img class="img-fluid"
                         src="${e.target.result}"
                         alt="@lang('Favicon')">
                    `);
                    $(preview).addClass('has-image');
                    $(preview).hide();
                    $(preview).fadeIn(650);
                }
                reader.readAsDataURL(input.files[0]);
            }
          }
          $("#favicon").on('change',function() {
            proPicURLfavicon(this);
          });

    </script>
@endpush
