@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-indigo-500 text-white">
                    <h4 class="card-title"> @lang('Upload Your Video') </h4>
                </div>
                <form action="{{route('user.upload.store')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        <div class="form-group col-md-12">
                            <label for="title"> @lang('Title') </label>
                            <input type="text" name="title" id="title" class="form-control">
                        </div>
                        <div class="form-group col-md-12">
                            <label for="description"> @lang('Description') </label>
                            <textarea name="description" id="description" class="form-control"></textarea>
                        </div>

                        <div class="form-group col-md-12">
                            <label for="video"> @lang('Video File') </label>
                            <input type="file" name="video" id="video" class="form-control"/>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn float-end bg-indigo-500 hover:bg-indigo-700 text-white"> @lang('Upload') </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection