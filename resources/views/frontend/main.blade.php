@extends('layouts.frontend')
@section('content')
    <div class="container">
        @foreach ($videos as $key=>$items)
            <div class="row">
                <div class="card">
                    <div class="card-header bg-indigo-500 text-white">
                        <span class="h3"> {{__($key)}} </span>    
                    </div>   
                    <div class="card-body">
                        <div class="row">
                            @forelse ($items as $j=>$val)
                                <div class="col-md-3">
                                    <div class="card">
                                        <div class="card-body video">
                                            <video width="100%" height="300" controls>
                                                <source src="{{asset($val->path)}}" type="video/mp4">
                                            </video>
                                        </div>
                                        <div class="card-footer">
                                            <span class="h4 d-block"> 
                                                <form action="{{route('watch')}}" method="get">
                                                    <input type="hidden" name="v" value="{{$val->id}}">
                                                    <button onclick="this.form.submit()"> {{__($val->title)}} </button>
                                                </form>
                                            </span>
                                            <span> {{$val->watched}} @lang('views') | </span>
                                            <span> {{$val->created_at->diffforhumans()}} </span>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                
                            @endforelse    
                        </div>    
                    </div> 
                </div>            
            </div>
        @endforeach
    </div>
@endsection
@push('script')
    <script>
        $(function(){
            $(".video").on({
                mouseenter: function () {
                    $('video', this).get(0).play(); 
                },
                mouseleave: function () {
                    $('video', this).get(0).pause(); 
                }
            });
        })
    </script>
@endpush