@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <form action="{{route('user.video.details.update')}}" method="post">
                @csrf
                <input type="hidden" name="videoId" value="{{$video->id}}">
                <div class="card">
                    <div class="card-header text-white bg-indigo-500">
                        <h3 class="card-title"> @lang('Update Your Video Informations') </h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-7">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="row justify-content-center">
                                            <div class="col-md-8">
                                                <div class="text-center">
                                                    <div class="profilePreview">
                                                        <img class="profile-user-img img-fluid img-circle"
                                                         src="{{asset(path()['admin']['path'].'/')}}"
                                                         alt="">
                                                    </div>
                                                    <div class="mt-3 mb-3">
                                                        <input type="file" name="image" id="upload" class="d-none" accept=".png, .jpg, .jpeg">
                                                        <label data-toggle="tooltip" data-original-title="@lang('Upload Thumbnail')" class="btn bg-indigo-500 hover:bg-indigo-700 text-white" for="upload">
                                                            <i class="las la-pen"></i>
                                                        </label>
                                                    </div>
                                                  </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label for="title"> @lang('Title') <span class="text-pink-500">*</span> </label>
                                        <input type="text" class="form-control" name="title" placeholder="@lang('Your Video Title')">
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label for="category"> @lang('Select Category') <span class="text-pink-500">*</span> </label>
                                        <select class="form-control singleSelect" name="category" id="category">
                                            <option value=""> @lang('Select One') </option>
                                            @forelse ($categories as $item)
                                                <option value="{{$item->id}}"> {{__($item->name)}} </option>
                                            @empty
                                                <option value=""> @lang('No Data') </option>
                                            @endforelse
                                        </select>
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label for="tags"> @lang('Tags') </label>
                                        <select name="tags[]" multiple id="tags" class="form-control select2"></select>
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label for="description"> @lang('Description') <span class="text-pink-500">*</span> </label>
                                        <textarea type="description" class="form-control" name="description" placeholder="@lang('Details About Your Video')"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="row">
                                    <div class="col-md-12">
                                        <span class="h4"> @lang('Uploaded Video Information') </span>
                                    </div>
                                </div>
                                <div class="row mt-3 mb-3">
                                    <video width="320" height="240" autoplay controls>
                                        <source src="{{asset($video->path)}}" type="video/mp4">
                                    </video>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-md-12">
                                        <ul class="list-group">
                                            <li class="list-group-item d-flex justify-content-between">
                                                <span class="fw-bold"> @lang('Size') </span>
                                                <span class="fw-bold"> @if ($userPlan->storage_unit == \App\Models\Plan::MB)
                                                    {{(formatBytes($video->size,'MB'))}} @lang('MB')
                                                    @elseif ($userPlan->storage_unit == \App\Models\Plan::GB)
                                                    {{formatBytes($video->size,'GB')}} @lang('GB')
                                                    @elseif ($userPlan->storage_unit == \App\Models\Plan::TB)
                                                    {{formatBytes($video->size,'TB')}} @lang('TB')
                                                @endif  </span>
                                            </li>
                                          </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="row">
                            <div class="col-md-12">
                                <button type="submit" class="btn bg-indigo-500 hover:bg-indigo-700 text-white float-end"> @lang('Submit') </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
@push('script')
    <script>
        $(function(){
            "use strict"
            $('.select2').select2(
                {
                    tags:true,
                    placeholder: "@lang('Define Relative Tags For')",
                    allowClear: true
                }
            );

            $('.singleSelect').select2();

        })
    </script>
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
