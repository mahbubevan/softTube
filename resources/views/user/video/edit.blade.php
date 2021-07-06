@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <form action="" method="post">
                <div class="card">
                    <div class="card-header text-white bg-indigo-500">
                        <h3 class="card-title"> @lang('Update Your Video Informations') </h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="form-group col-md-12">
                                <label for="category"> @lang('Select Category') <span class="text-pink-500">*</span> </label>
                                <select class="form-control" name="category" id="category">
                                    <option value=""> @lang('Select One') </option>
                                </select>
                            </div>
                            <div class="form-group col-md-12">
                                <label for="title"> @lang('Title') <span class="text-pink-500">*</span> </label>
                                <input type="text" class="form-control" name="title" placeholder="@lang('Your Video Title')">
                            </div>
                            <div class="form-group col-md-12">
                                <label for="description"> @lang('Description') <span class="text-pink-500">*</span> </label>
                                <textarea type="description" class="form-control" name="description" placeholder="@lang('Details About Your Video')"></textarea>
                            </div>
                            <div class="form-group col-md-12">
                                <label for="tags"> @lang('Tags') </label>
                                <select name="tags[]" multiple id="tags" class="form-control select2">
                                    
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">

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
            $('.select2').select2();
        })
    </script>
@endpush