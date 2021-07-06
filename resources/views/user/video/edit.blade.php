@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-indigo-500 text-white">
                    <h4 class="card-title"> @lang('Upload Your Video') </h4>
                </div>
                <form>
                    @csrf
                    <div class="card-body">
                        <div class="form-group col-md-12">
                            <input type="file" name="video" id="video" class="form-control"/>
                        </div>
                        <div class="form-group col-md-12 mt-3 mb-3">
                            <div class="progress">
                                <div class="progress-bar bg-indigo-500" role="progressbar" style="width:0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">0%</div>
                            </div>
                        </div>
                    </div>
                </form>
                <div class="custom-footer"></div>
            </div>
        </div>
    </div>
</div>
@endsection