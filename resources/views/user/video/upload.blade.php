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
                        <div class="form-group col-md-12 mt-3 mb-3">
                            <div class="progress">
                                <div class="progress-bar bg-indigo-500" role="progressbar" style="width:0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">0%</div>
                            </div>
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
@push('script')
    <script>
        "use strict"
        $(function(){
            $("#video").on("change",function(e){
                $(".progress-bar").css("width","0%")
                var files = $("#video")[0].files[0]
                var name = files.name
                var size = files.size // total file size
                var type = files.type
                var start = 0;
                var step = 1048576; //chunkSize
                var loaded = 0;
                var chunks = Math.ceil(size/step,step);
                var chunk = 0;
                var url = "{{route('user.check.ext.size')}}"
                $.ajax({
                    type:"POST",
                    url,
                    data:{
                        name,
                        size,
                        type,
                        _token:"{{csrf_token()}}"
                    }
                }).done(function(data){
                    var reader = new FileReader();
                    var blob = files.slice(start,step);
                    reader.readAsBinaryString(blob);

                    reader.onload = function(e){
                        var postUrl = "{{route('user.upload.store')}}"
                        $.ajax({
                            url:postUrl,
                            type:"POST",
                            // processData: false,
                            // contentType: false,
                            data:{
                                videos:reader.result,
                                _token:"{{csrf_token()}}",
                                step,
                                size,
                                type
                            },
                        }).done(function(data){
                            loaded += step;
                            console.log(data,size,loaded);
                            var uploadProgress = Math.min((loaded / size) * 100, 100);

                            $(".progress-bar").css("width",`${uploadProgress}%`)
                            $(".progress-bar").text(`${uploadProgress}%`)

                            if (loaded <= size) {
                                blob = files.slice(loaded,loaded+step)
                                reader.readAsBinaryString(blob)
                            }else{
                                loaded = size
                                toastr.success("Uploaded Successfully")
                            }



                        }).fail(function(data){
                            console.log(data);
                        })
                    }
                }).fail(function(data){
                    console.log(data);
                    toastr.error(data.responseJSON.error)
                })

            })
        })
    </script>
@endpush
