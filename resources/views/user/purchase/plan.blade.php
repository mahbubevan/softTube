@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        @foreach ($plans as $item)
        <div class="col-md-4">
            <div class="card">
                <div class="card-header bg-indigo-500 text-white">
                    <h1 class="card-title display-4"> {{__($item->name)}} </h1>
                </div>
                <div class="card-body">
                    <ul class="list-group">
                        <li class="list-group-item d-flex justify-content-between fw-bold">
                            <span> @lang('Storage') </span>
                            <span> {{number_format($item->storage)}} @if ($item->storage_unit==\App\Models\Plan::MB)
                                @lang('MB')
                                @elseif($item->storage_unit==\App\Models\Plan::GB)
                                    @lang('GB')
                                @else 
                                @lang('TB')
                            @endif </span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between fw-bold">
                            <span> @lang('Storage Type') </span>
                            <span>
                                @if ($item->storage_type==\App\Models\Plan::LOCAL)
                                    @lang('Local Storage')
                                    @else 
                                    @lang('Amazon S3')
                                @endif
                            </span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between fw-bold">
                            <span> @lang('Plan Type') </span>
                            @if ($item->type==\App\Models\Plan::LIFETIME)
                                @lang('Purchase For Lifetime')
                                @else 
                                @lang('Recurring Purchase Plan')
                            @endif
                        </li>
                        <li class="list-group-item d-flex justify-content-between fw-bold">
                            <span> @lang('Recurring Plan Method') </span>
                            <span>
                                @if ($item->type == \App\Models\Plan::LIFETIME)
                                    @lang('Not Aplicable')
                                @else
                                    @if ($item->renewal_type == \App\Models\Plan::MONTHLY)
                                        @lang('Monthly')
                                        @else 
                                        @lang('Yearly')
                                    @endif
                                @endif
                            </span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between fw-bold">
                            <span> @lang('Price') </span>
                            <span> {{number_format($item->price)}} {{__($setting->currency)}} </span>
                        </li>
                      </ul>
                </div>
                <div class="card-footer">
                    @if ($item->stripe_price == $stripe_price)
                        <button class="btn w-100 bg-gray-500 text-white" disabled="disabled"> @lang('Purchased') </button>
                    @else
                        <a href="{{route('user.purchase.plan',$item->id)}}" class="btn w-100 bg-indigo-500 hover:bg-indigo-700 text-white"> @lang('Purchase') </a>
                    @endif
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection