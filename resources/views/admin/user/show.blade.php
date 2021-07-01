@extends('admin.layouts.master')
@section('content')
<div class="container-fluid">
    <form class="form-horizontal" action="{{route('admin.user.update',$user->id)}}" method="POST" enctype="multipart/form-data">
      <div class="row">
        <div class="col-md-4">
          <!-- Profile Image -->
          <div class="card card-primary card-outline">
            <div class="card-body box-profile">
              <div class="text-center">
                <div class="profilePreview">
                    <img class="profile-user-img img-fluid img-circle"
                     src="{{asset(path()['user']['path'].'/'.$user->image)}}"
                     alt="@lang('User profile picture')">
                </div>
              </div>

              <h3 class="profile-username text-center mb-2 mt-2">{{$user->email}}</h3>

              <ul class="list-group list-group-unbordered mb-3">
                <li class="list-group-item">
                    <b> @lang('Full Name') </b> <a class="float-right"> {{$user->name}} </a>
                  </li>
                <li class="list-group-item">
                  <b> @lang('Username') </b> <a class="float-right">{{$user->username}}</a>
                </li>
                <li class="list-group-item">
                  <b> @lang('Balance') </b> <a class="float-right">{{number_format($user->balance,2)}} {{__($setting->currency)}} </a>
                </li>

                <li class="list-group-item">
                  <b> @lang('Last Updated At') </b> <a class="float-right"> {{$user->updated_at->diffforhumans()}} </a>
                </li>
              </ul>
            </div>
            <!-- /.card-body -->
          </div>
        </div>
        <!-- /.col -->
        <div class="col-md-8">
          <div class="card">
            <div class="card-header p-2 bg-indigo-500 text-white">
              <h4 class="card-title"> @lang('Information') </h4>
            </div><!-- /.card-header -->
            <div class="card-body">
                    @csrf
              <div class="row mb-2">
                <div class="form-group col-md-12">
                  <label for="inputName" class="col-form-label"> @lang('Name') </label>
                  <input type="text" name="name" value="{{$user->name}}" class="form-control" id="inputName" placeholder="@lang('Name')">
                </div>
                <div class="form-group col-md-12">
                  <label for="inputEmail" class="col-form-label"> @lang('Email') </label>
                  <input type="email" name="email" value="{{$user->email}}" class="form-control" id="inputEmail" placeholder="@lang('Email')">
                </div>
                <div class="form-group col-6">
                  <label for="ev" class="d-block">{{__('Email Verified')}}</label>
                  <input type="checkbox" data-width="100%" data-onstyle="success" data-offstyle="danger" data-toggle="toggle" data-on="@lang('Verified')" data-off="@lang('Unverified')" name="ev" @if($user->email_verified_at != null) checked @endif>
              </div>
              <div class="form-group col-6">
                <label for="status" class="d-block">{{__('Status')}}</label>
                <input type="checkbox" data-width="100%" data-onstyle="success" data-offstyle="danger" data-toggle="toggle" data-on="@lang('Active')" data-off="@lang('Deactive')" name="ev" @if($user->status) checked @endif>
            </div>
              </div>
                    
              <div class="row">
                <div class="col-md-12">
                  <button type="submit" class="btn bg-indigo-500 hover:bg-indigo-700 text-white"> @lang('Update') </button>
                </div>
              </div>
            </div><!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
        <!-- /.col -->
      </div>
    </form>
</div>
@endsection
