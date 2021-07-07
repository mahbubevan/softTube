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
                                <div class="like h3"> <span>0</span> <span><i class="las la-thumbs-up"></i></span> </div>
                                <div class="dislike h3"> <span>0</span> <span><i class="las la-thumbs-down"></i></span> </div>
                                <div class="share h3"> <span></span> <span><i class="las la-share-alt-square"></i></span> </div>
                                <div class="watchlater h3"> <span></span> <span><i class="las la-folder-plus"></i></span> </div>
                                <div class="report h3"> <span></span> <span><i class="las la-flag"></i></span> </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="video-description">

                    </div>
                </div>
                <div class="row mt-3">
                    <div class="video-comments">
                        
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <span class="h2"> @lang('Related Videos') </span>
            </div>
        </div>
    </div>
@endsection
@push('script')

@endpush