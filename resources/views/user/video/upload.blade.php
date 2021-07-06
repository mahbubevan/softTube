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
@push('script')
    <script>
        "use strict"
        $(function(){
            $("#video").on("change",function(e){
                $(".progress-bar").css("width","0%")
                var files = $("#video")[0].files[0]
                var name = files.name
                var size = files.size
                var type = files.type
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
                    var formData = new FormData()
                    formData.append('video',files)
                    formData.append('size',size)
                    formData.append('_token',"{{csrf_token()}}")

                    var xmlhttp = new XMLHttpRequest(), method = "POST", url = "{{route('user.upload.store')}}"
                    xmlhttp.upload.addEventListener("progress",progressHandler,false)
                    xmlhttp.addEventListener("load",completeHandler,false)
                    xmlhttp.addEventListener("error",errorHandler,false)
                    xmlhttp.addEventListener("abort",abortHandler,false)
                    xmlhttp.open(method,url,true)
                    xmlhttp.send(formData)

                    function progressHandler(event) {
                        var uploadProgress = Math.round((event.loaded / event.total) * 100);
                        $(".progress-bar").css("width",`${uploadProgress}%`)
                        $(".progress-bar").text(`${uploadProgress}%`)
                    }
                    function completeHandler(event) {
                        var jsonResponse = JSON.parse(xmlhttp.response)
                        if (jsonResponse.status == 0) {
                            var id = jsonResponse.video
                            $(".custom-footer").html(`
                                <form action="{{route('user.video.details.edit')}}" method="GET">
                                    <input type="hidden" name="videoId" id="videoId" value="${id}"/>
                                    <div class="card-footer">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <button type="submit" class="btn bg-indigo-500 hover:bg-indigo-700 text-white float-end"> @lang('Next') </button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            `)
                        }
                        toastr.success("File Uploaded Successfully");
                    }

                    function errorHandler(event) {

                     }

                    function abortHandler(event) {

                     }


                     xmlhttp.onreadystatechange = function(data)
                     {
                         if (xmlhttp.status == 413) {
                            toastr.error("File Uploaded Failed. File Too Large");
                         }

                         if (xmlhttp.status == 500) {

                         }
                     }

                }).fail(function(data){
                    toastr.error(data.responseJSON.error)
                })

            })
        })
    </script>
@endpush



