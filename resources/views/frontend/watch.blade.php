@extends('layouts.frontend')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div class="row">
                    <div class="col-md-12 video-watch">
                        <video width="100%" muted height="600" autoplay controls>
                            <source src="{{asset($video->path)}}" type="video/mp4">
                        </video>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-md-12 video-information">
                        <span class="h3 d-block"> {{__(@$video->title)}} </span>
                        <div class="d-flex justify-content-between">
                            <div>
                                <span> {{@$video->watched}} @lang('views') </span>
                                |
                                <span> @lang('Uploaded ') {{$video->created_at->diffforhumans()}} </span>
                            </div>
                            <div class="d-flex justify-content-evenly">
                                <div class="like h3">
                                    <span>0</span>
                                    <span data-toggle="tooltip" title="@lang('Like')" id="like" class="link"><i class="las la-thumbs-up"></i></span>
                                </div>
                                <div class="dislike h3"> <span>0</span> <span data-toggle="tooltip" title="@lang('Dislike')" class="link" id="dislike"><i class="las la-thumbs-down"></i></span> </div>
                                <div class="share h3"> <span></span> <span data-toggle="tooltip" title="@lang('Share')" class="link" id="share"><i class="las la-share-alt-square"></i></span> </div>
                                <div class="watchlater h3"> <span></span> <span data-toggle="tooltip" title="@lang('Add To Watch Later')" class="link" id="watchlater"><i class="las la-folder-plus"></i></span> </div>
                                <div class="report h3"> <span></span> <span data-toggle="tooltip" title="@lang('Report')" class="link" id="report"><i class="las la-flag"></i></span> </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mt-3 video-description">
                    <div class="col-md-9">
                        <span class="h2"> @lang('Description') </span>
                    </div>
                    <div class="col-md-3">
                        <a href="#0" class="btn bg-pink-800 text-white"> @lang('Subscribe') </a>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="video-comments">
                        <span class="h3">0 @lang('Comments') </span>
                        <div class="comments"></div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <span class="h2"> @lang('Related Videos') </span>
            </div>
        </div>
    </div>
@endsection
@push('style')
    <style>
        .link{
            cursor: pointer;
        }
    </style>
@endpush
@push('script')
    <script>
        $(function(){
            $("#like").on("click",function(){
                console.log("hello");
                var url = "{{route('user.like')}}"
                var id = "{{$video->id}}"

                $.ajax({
                    url,
                    method:"POST",
                    data:{
                        _token:"{{csrf_token()}}",
                        id
                    }
                }).done(function(data){
                    console.log(data);
                }).fail(function(data){
                    if (data.status == 401) {
                        
                    }
                })
            })
        })
    </script>
@endpush
