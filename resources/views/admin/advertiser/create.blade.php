@extends('admin.layouts.master')
@section('content')
<div class="container-fluid">
    <form action="{{route('admin.plan.store')}}" method="post">
        @csrf
        <div class="card">
            <div class="card-header bg-indigo-500 text-white">
                <h4 class="card-title"> @lang('Advertiser Information') </h4>
            </div>
            <div class="card-body">
                <div class="row addedField">

                </div>
            </div>
            <div class="card-footer">
                <button type="button" class="btn float-right bg-indigo-500 hover:bg-indigo-700 text-white addField">
                    @lang('Add Field')
                </button>
            </div>
        </div>
        <div class="card">
            <div class="card-header bg-indigo-500 text-white">
                <h4 class="card-title"> @lang('Advertise Information') </h4>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="form-group col-md-6">
                        <label for="addName"> @lang('Ad Name') <span class="text-pink-700">*</span> </label>
                        <input type="text" id="addName" name="price" class="form-control" placeholder="@lang('Ad Name')">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="addSize"> @lang('Ad Size') <span class="text-pink-700">*</span> </label>
                        <select name="add_size" id="addSize" class="select2 form-control">
                            <option value="320x250"> @lang('320x250') </option>
                            <option value="728x90"> @lang('728x90') </option>
                            <option value="300x600"> @lang('300x600') </option>
                        </select>
                    </div>

                    <div class="form-group col-md-6">
                        <label for="addType"> @lang('Ad Type') <span class="text-pink-700">*</span> </label>
                        <select name="add_type" id="addType" class="select2 form-control">
                            <option value="{{\App\Models\Advertiser::BANNER}}"> @lang('Banner') </option>
                            <option value="{{\App\Models\Advertiser::SCRIPT}}"> @lang('Script') </option>
                            <option value="{{\App\Models\Advertiser::VIDEO}}"> @lang('Video') </option>
                        </select>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="image"> @lang('Image') <span class="text-pink-700">*</span> </label>
                        <input type="file" id="image" name="image" class="form-control" />
                    </div>
                    <div class="form-group col-md-6">
                        <label for="script"> @lang('Script') <span class="text-pink-700">*</span> </label>
                        <textarea id="script" name="script" class="form-control"></textarea>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="redirectUrl"> @lang('Redirect Url') <span class="text-pink-700">*</span> </label>
                        <input type="text" id="redirectUrl" name="redirectUrl" class="form-control" />
                    </div>
                    <div class="form-group col-md-6">
                        <label for="video_link"> @lang('Video Url') <span class="text-pink-700">*</span> </label>
                        <input type="text" id="video_link" name="video_link" class="form-control" />
                    </div>
                    <div class="form-group col-md-6">
                        <label for="video"> @lang('Video') <span class="text-pink-700">*</span> </label>
                        <input type="file" id="video" name="video" class="form-control" />
                    </div>

                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn float-right bg-indigo-500 hover:bg-indigo-700 text-white">
                    @lang('Submit')
                </button>
            </div>
        </div>
    </form>
</div>
@endsection
@push('script')
    <script>
        "use strict"
        $(function(){
            var i = 0;
            $(".addField").on("click",function(){
                i++
                $(".addedField").append(`
                    <div class="form-group col-md-3">
                        <label for="key"> @lang('Key') <span class="text-pink-700">*</span> </label>
                        <input type="text" id="key${i}" name="key[]" class="form-control" placeholder="@lang('Full Name')">
                    </div>
                    <div class="form-group col-md-3">
                        <label for="value"> @lang('Value') <span class="text-pink-700">*</span> </label>
                        <input type="text" id="value${i}" name="value[]" class="form-control" placeholder="@lang('John Doe')">
                    </div>
                `)
            })

        })
    </script>
    <script>
        $(function(){
            $(".select2").select2()
        })
    </script>
@endpush
