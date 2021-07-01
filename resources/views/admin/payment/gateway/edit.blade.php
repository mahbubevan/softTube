@extends('admin.layouts.master')
@section('content')
<div class="container-fluid">
    <form class="form-horizontal" action="{{route('admin.payment.gateway.update',$item->id)}}" method="POST" enctype="multipart/form-data">
      <div class="row">
        <div class="col-md-4">
          <!-- Profile Image -->
          <div class="card card-primary card-outline">
            <div class="card-body box-profile">
              <div class="text-center">
                <div class="profilePreview">
                    <img class="profile-user-img img-fluid img-circle"
                     src="{{asset(path()['gateway']['path'].'/'.$item->image)}}"
                     alt="@lang('User profile picture')">
                </div>
                <div class="mt-3 mb-3">
                    <input type="file" name="image" id="upload" class="d-none" accept=".png, .jpg, .jpeg">
                    <label data-toggle="tooltip" data-original-title="@lang('Upload Image')" class="btn btn-sm bg-indigo-500 hover:bg-indigo-700 text-white" for="upload">
                        <i class="las la-pen"></i>
                    </label>
                </div>
              </div>

              <ul class="list-group list-group-unbordered mb-3">
                <li class="list-group-item">
                    <b> @lang('Method Name') </b> <a class="float-right"> {{@$item->method_name}} </a>
                  </li>
                <li class="list-group-item">
                  <b> @lang('Currency Type') </b> <a class="float-right">
                      @if ($item->currency_type==0)
                        <span class="badge badge-pill bg-blue-400 text-white p-1"> @lang('Fiat Currency') </span>
                        @else
                        <span class="badge badge-pill bg-blue-600 text-white p-1"> @lang('Crypto Currency') </span>
                      @endif
                  </a>
                </li>

                <li class="list-group-item">
                  <b> @lang('Status') </b> <a class="float-right">
                    @if ($item->status==1)
                    <span class="badge badge-pill bg-green-800 text-white p-1"> @lang('Active') </span>
                    @else
                    <span class="badge badge-pill bg-yellow-600 text-white p-1"> @lang('Deactive') </span>
                @endif
                </a>
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
              <h4 class="card-title"> @lang('Credential Update') </h4>
            </div><!-- /.card-header -->
            <div class="card-body">
                @csrf
                <div class="row">
                    @foreach ($item->credentials as $key=>$value)
                        <div class="from-group col-md-12">
                            <label for="{{$key}}"> {{__(modifyString($key,"_"))}} </label>
                            <input type="hidden" name="key[]" value="{{$key}}">
                            <input type="text" class="form-control" name="credentials[]" value="{{$value}}" placeholder="@lang('Required')">
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-sm text-white bg-indigo-500 hover:bg-indigo-700"> @lang('Update') </button>
            </div>
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
