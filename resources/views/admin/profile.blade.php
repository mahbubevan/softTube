@extends('admin.layouts.master')
@section('content')
<div class="container-fluid">
    <form class="form-horizontal" action="{{route('admin.profile.update')}}" method="POST" enctype="multipart/form-data">
      <div class="row">
        <div class="col-md-3">
          <!-- Profile Image -->
          <div class="card card-primary card-outline">
            <div class="card-body box-profile">
              <div class="text-center">
                <div class="profilePreview">
                    <img class="profile-user-img img-fluid img-circle"
                     src="{{asset(path()['admin']['path'].'/'.$admin->image)}}"
                     alt="@lang('Admin profile picture')">
                </div>
                <div class="mt-3 mb-3">
                    <input type="file" name="image" id="upload" class="d-none" accept=".png, .jpg, .jpeg">
                    <label data-toggle="tooltip" data-original-title="@lang('Upload Image')" class="btn btn-sm btn-info" for="upload"><i class="fas fa-pen-alt"></i></label>
                </div>
              </div>

              <h3 class="profile-username text-center">{{$admin->name}}</h3>

              <ul class="list-group list-group-unbordered mb-3">
                <li class="list-group-item">
                  <b> @lang('Username') </b> <a class="float-right">{{$admin->username}}</a>
                </li>
                <li class="list-group-item">
                  <b> @lang('Email') </b> <a class="float-right"> {{$admin->email}} </a>
                </li>
                <li class="list-group-item">
                  <b> @lang('Last Updated At') </b> <a class="float-right"> {{@$admin->updated_at->diffforhumans()}} </a>
                </li>
              </ul>
            </div>
            <!-- /.card-body -->
          </div>
        </div>
        <!-- /.col -->
        <div class="col-md-9">
          <div class="card">
            <div class="card-header p-2 bg-dark">
              <h4 class="card-title"> @lang('Information') </h4>
            </div><!-- /.card-header -->
            <div class="card-body">
                    @csrf
                    <div class="form-group row">
                      <label for="inputName" class="col-sm-2 col-form-label"> @lang('Name') </label>
                      <div class="col-sm-10">
                        <input type="text" name="name" value="{{$admin->name}}" class="form-control" id="inputName" placeholder="@lang('Name')">
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="inputEmail" class="col-sm-2 col-form-label"> @lang('Email') </label>
                      <div class="col-sm-10">
                        <input type="email" name="email" value="{{$admin->email}}" class="form-control" id="inputEmail" placeholder="@lang('Email')">
                      </div>
                    </div>
                    <div class="form-group row">
                      <div class="offset-sm-2 col-sm-10">
                        <button type="submit" class="btn btn-dark"> @lang('Update') </button>
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

@push('script')
<script>
    "use strict"
      function proPicURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                var preview = $(input).parents().find('.profilePreview');
                console.log(preview);
                $(preview).html(`
                <img class="profile-user-img img-fluid img-circle"
                     src="${e.target.result}"
                     alt="@lang('Admin profile picture')">
                `);
                $(preview).addClass('has-image');
                $(preview).hide();
                $(preview).fadeIn(650);
            }
            reader.readAsDataURL(input.files[0]);
        }
      }
      $(document).on('change',"#upload" ,function() {
        proPicURL(this);
      });

</script>
@endpush
