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
                                    <span id="likeCount">{{$video->likes_count}}</span>
                                    <span data-toggle="tooltip" title="@lang('Like')" id="like" class="link @if($video->isLikedByUser()) text-indigo-500 hover:text-indigo-700 @endif"><i class="las la-thumbs-up"></i></span>
                                </div>
                                <div class="dislike h3">
                                    <span id="dislikeCount">{{$video->dislikes_count}}</span>
                                    <span data-toggle="tooltip" title="@lang('Dislike')" class="link @if($video->isDislikedByUser()) text-indigo-500 hover:text-indigo-700 @endif" id="dislike"><i class="las la-thumbs-down"></i></span>
                                </div>
                                <div class="share h3"> <span></span> <span data-toggle="tooltip" title="@lang('Share')" class="link" id="share"><i class="las la-share-alt-square"></i></span> </div>
                                <div class="watchlater h3"> <span></span> <span data-toggle="tooltip" title="@lang('Add To Watch Later')" class="link" id="watchlater"><i class="las la-folder-plus"></i></span> </div>
                                <div class="report h3"> <span></span> <span data-toggle="tooltip" title="@lang('Report')" class="link" id="report"><i class="las la-flag"></i></span> </div>
                            </div>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="row mt-3 video-description">
                    <div class="col-md-9">
                        <span class="h3 d-block"> {{__($video->user->username)}} </span>
                        <span class="h6 d-block"> <span id="subscriptionCount"> {{__($video->user->subscribedBy()->count())}} </span> @lang('subscribers') </span>
                    </div>
                    <div class="col-md-3 subs-dcsn">
                        @if($video->user->isSubscribedBy())
                            <button id="unsubscribe" class="btn bg-gray-400 text-white"> @lang('Subscribed') </button>
                        @else
                            <button id="subscribe" class="btn bg-pink-800 text-white"> @lang('Subscribe') </button>
                        @endif
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="video-comments">
                        <span class="h3">{{$video->comments_count}} @lang('Comments') </span>
                        <div class="new-comment-input mb-5">
                            <form action="{{route('user.comment')}}" method="post">
                                @csrf
                                <input type="hidden" name="videoId" value="{{$video->id}}">
                                <input type="text" name="comment" class="form-control border-top-0 border-start-0 border-end-0 border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-600 focus:border-transparent">
                                <button type="submit" class="btn btn-md bg-purple-600 mt-3 text-white float-end"> @lang('Comment') </button>
                            </form>
                        </div>
                        <div class="comments mt-5">
                            @forelse ($video->comments as $item)
                                <div class="comment-name">
                                    {{__($item->user->name)}} - {{$item->created_at->diffforhumans()}}
                                </div>
                                <div class="user-comment">
                                    {{__($item->comment)}}
                                </div>
                            @empty
                                <div class="no-comment">
                                    @lang('No Comment')
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <span class="h2"> @lang('Related Videos') </span>
            </div>
        </div>
    </div>

    <!-- Modal -->
<div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel"> @lang('Login Required') </h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <span class="h4 text-center d-block t1"></span>
          <span class="h6 text-center d-block t2"></span>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-sm bg-black text-white" data-bs-dismiss="modal"> @lang('Close') </button>
          <a href="{{route('login')}}" class="btn btn-sm bg-indigo-500 hover:bg-indigo-700 text-white"> @lang('Login') </a>
        </div>
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
        "use strict"
        $(function(){
            $("#like").on("click",function(){
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
                    if (data.status) {
                        $("#like").addClass('text-indigo-500 hover:text-indigo-700')
                    }else{
                        $("#like").removeClass('text-indigo-500 hover:text-indigo-700')
                    }

                    if (data.flag == 1) {
                        $("#dislike").removeClass('text-indigo-500 hover:text-indigo-700')
                    }

                    $("#likeCount").text(data.likeCount)
                    $("#dislikeCount").text(data.dislikeCount)

                }).fail(function(data){
                    if (data.status == 401) {
                        var myModal = new bootstrap.Modal(document.getElementById('loginModal'))
                        $('.t1').text("@lang('Liked This Video') ?")
                        $('.t2').text("@lang('Login To Make Your Like Count')")

                        myModal.show()
                    }
                })
            })

            $("#dislike").on("click",function(){
                var url = "{{route('user.dislike')}}"
                var id = "{{$video->id}}"

                $.ajax({
                    url,
                    method:"POST",
                    data:{
                        _token:"{{csrf_token()}}",
                        id
                    }
                }).done(function(data){
                    if (data.status) {
                        $("#dislike").addClass('text-indigo-500 hover:text-indigo-700')
                    }else{
                        $("#dislike").removeClass('text-indigo-500 hover:text-indigo-700')
                    }

                    if (data.flag == 1) {
                        $("#like").removeClass('text-indigo-500 hover:text-indigo-700')
                    }

                    $("#likeCount").text(data.likeCount)
                    $("#dislikeCount").text(data.dislikeCount)

                }).fail(function(data){
                    if (data.status == 401) {
                        var myModal = new bootstrap.Modal(document.getElementById('loginModal'))
                        $('.t1').text("@lang('Disliked This Video') ?")
                        $('.t2').text("@lang('Login To Make Your Dislike Count')")
                        myModal.show()
                    }
                })
            })

            $(document).on("click","#subscribe",function(){
                var url = "{{route('user.subscribe')}}"
                var id = "{{$video->id}}"

                $.ajax({
                    url,
                    method:"POST",
                    data:{
                        _token:"{{csrf_token()}}",
                        id
                    }
                }).done(function(data){
                    if (data.status) {
                       $(".subs-dcsn") .html(`<button id="unsubscribe" class="btn bg-gray-400 text-white"> @lang('Subscribed') </button>`)
                       $("#subscriptionCount").text(data.subscribeCount)
                    }

                }).fail(function(data){
                    console.log(data);
                    if (data.status == 401) {
                        var myModal = new bootstrap.Modal(document.getElementById('loginModal'))
                        $('.t1').text("@lang('Want To Subscribe This Video') ?")
                        $('.t2').text("@lang('Login To Subscribe')")
                        myModal.show()
                    }
                })
            })

            $(document).on("click","#unsubscribe",function(){
                var url = "{{route('user.subscribe')}}"
                var id = "{{$video->id}}"

                $.ajax({
                    url,
                    method:"POST",
                    data:{
                        _token:"{{csrf_token()}}",
                        id
                    }
                }).done(function(data){
                    if (!data.status) {
                       $(".subs-dcsn") .html(`<button id="subscribe" class="btn bg-pink-800 text-white"> @lang('Subscribe') </button>`)
                       $("#subscriptionCount").text(data.subscribeCount)
                    }

                }).fail(function(data){
                    if (data.status == 401) {
                        var myModal = new bootstrap.Modal(document.getElementById('loginModal'))
                        $('.t1').text("@lang('Want To Subscribe This Video') ?")
                        $('.t2').text("@lang('Login To Subscribe')")
                        myModal.show()
                    }
                })
            })

        })
    </script>

    <script>
        "use strict"
        var flag = "{{$viewCounted}}"
        if (flag==1) {
            var url = "{{route('user.video.view.count')}}"
            var watchDuration = 30

            const video = document.querySelector('video');
            video.ontimeupdate = (event) => {
                var duration = video.duration % 60;
                var currentTime = video.currentTime;
                var percentage = Math.round((currentTime / duration) * 100);
                console.log(percentage);
                if (percentage > watchDuration) {
                    $.ajax({
                    url,
                    method:"POST",
                    data:{
                        _token:"{{csrf_token()}}",
                        videoId:"{{$video->id}}"
                    }
                    }).done(function(data){
                        console.log(data);
                    }).fail(function(data){
                        console.log(data);
                    })

                }

            };
        }       
    </script>
@endpush
