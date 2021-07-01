@extends('admin.layouts.master')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header bg-indigo-500">
                <h3 class="card-title text-white">{{__('Gateways Lists')}}</h3>
              </div>
            <div class="card-body table-responsive p-0">
              <table class="table table-head-fixed text-nowrap">
                <thead>
                  <tr>
                    <th> {{__('Method Name')}} </th>
                    <th>{{__('Currency Type')}} </th>
                    <th>{{__('Status')}} </th>
                    <th>{{__('Action')}}</th>
                  </tr>
                </thead>
                <tbody>
                    @forelse ($items as $item)
                    <tr>
                        <td>
                            {{$item->method_name}}
                        </td>
                        <td>
                            @if ($item->currency_type==0)
                                <span class="badge badge-pill bg-blue-400 text-white p-1"> @lang('Fiat Currency') </span>
                                @else
                                <span class="badge badge-pill bg-blue-600 text-white p-1"> @lang('Crypto Currency') </span>
                            @endif
                        </td>
                        <td>
                            @if ($item->status==1)
                                <span class="badge badge-pill bg-green-800 text-white p-1"> @lang('Active') </span>
                                @else
                                <span class="badge badge-pill bg-yellow-600 text-white p-1"> @lang('Deactive') </span>
                            @endif
                        </td>
                        <td>
                            <a href="{{route('admin.payment.gateway.edit',$item->id)}}"
                                data-toggle="tooltip"
                                data-original-title="@lang('Edit')"
                                class="btn btn-sm bg-indigo-500 hover:bg-indigo-700 text-white edit">
                                <i class="las la-pen"></i>
                            </a>
                            @if ($item->status==1)
                                <a href="{{route('admin.payment.gateway.deactive',$item->id)}}"
                                    data-toggle="tooltip"
                                    data-original-title="@lang('Deactive')"
                                    class="btn btn-sm bg-yellow-500 hover:bg-yellow-700 text-white">
                                    <i class="las la-ban"></i>
                                </a>
                                @else
                                <a href="{{route('admin.payment.gateway.active',$item->id)}}"
                                    data-toggle="tooltip"
                                    data-original-title="@lang('Active')"
                                    class="btn btn-sm bg-green-500 hover:bg-green-700 text-white">
                                    <i class="las la-check-circle"></i>
                                </a>
                            @endif
                        </td>
                      </tr>
                    @empty
                      <tr>
                          <td class="text-center" colspan="100%"> {{__('No Data')}} </td>
                      </tr>
                    @endforelse
                </tbody>
              </table>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
      </div>
</div>

@endsection
