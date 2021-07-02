@extends('admin.layouts.master')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header bg-indigo-500">
              <h3 class="card-title text-white">{{__('Plans List')}}</h3>
              <div class="card-tools">
                <div class="input-group input-group-sm">
                    <a href="{{route('admin.plan.create')}}" class="btn btn-sm bg-green-500 hover:bg-green-700 text-white"> @lang('Add New') </a>
                </div>
              </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body table-responsive p-0">
              <table class="table table-head-fixed text-nowrap">
                <thead>
                  <tr>
                    <th>{{__('Name')}}</th>
                    <th>{{__('Price')}}</th>
                    <th>{{__('Storage')}}</th>
                    <th>{{__('Storage Unit')}}</th>
                    <th>{{__('Storage Type')}}</th>
                    <th>{{__('Plan Type')}}</th>
                    <th>{{__('Renewal Type')}}</th>
                    <th>{{__('Withdrawal Type')}}</th>
                    <th>{{__('Action')}}</th>
                  </tr>
                </thead>
                <tbody>
                    @forelse ($plans as $item)
                    <tr>
                        <td> {{$item->name}} </td>
                        <td> {{number_format($item->price)}} {{$setting->currency??"USD"}} </td>
                        <td> {{number_format($item->storage)}} </td>
                        <td>
                            @if ($item->storage_unit==\App\Models\Plan::MB)
                                <span class="badge bg-blue-500 text-white"> @lang('MB') </span>
                            @elseif ($item->storage_unit==\App\Models\Plan::GB)
                                <span class="badge bg-green-500 text-white"> @lang('GB') </span>
                            @else
                                <span class="badge bg-pink-500 text-white"> @lang('TB') </span>
                            @endif
                        </td>
                        <td>
                            @if ($item->storage_type==\App\Models\Plan::LOCAL)
                                <span class="badge bg-blue-500 text-white"> @lang('Local Storage') </span>
                            @else
                                <span class="badge bg-pink-500 text-white"> @lang('Amazon S3') </span>
                            @endif
                        </td>
                        <td>
                            @if ($item->type==\App\Models\Plan::LIFETIME)
                                <span class="badge bg-info text-white"> @lang('Life Time') </span>
                            @else 
                                <span class="badge bg-warning text-white"> @lang('Recurring') </span>
                            @endif
                        </td>
                        <td>
                            @if ($item->type==\App\Models\Plan::RECURRING)
                                @if ($item->renewal_type==\App\Models\Plan::MONTHLY)
                                    <span class="badge bg-yellow-500 text-white"> @lang('Monthly') </span>
                                        @else 
                                    <span class="badge bg-indigo-500 text-white"> @lang('Yearly') </span>
                                @endif
                                @else 
                                <span class="badge bg-gray-500 text-white"> @lang('Not Applicable') </span>
                            @endif
                        </td>
                        <td>
                            @if ($item->withdrawal_type==\App\Models\Plan::DAILY)
                                <span class="badge bg-blue-500 text-white"> @lang('DAILY') </span>
                            @elseif ($item->withdrawal_type==\App\Models\Plan::WEEKLY)
                                <span class="badge bg-green-500 text-white"> @lang('WEEKLY') </span>
                            @elseif ($item->withdrawal_type==\App\Models\Plan::MONTHLY)
                                <span class="badge bg-green-500 text-white"> @lang('MONTHLY') </span>
                            @else
                                <span class="badge bg-pink-500 text-white"> @lang('YEARLY') </span>
                            @endif
                        </td>
                        <td>
                            <span data-toggle="tooltip" data-original-title="@lang('Edit')">
                                <a class="btn btn-sm bg-green-500 hover:bg-green-600 text-white" href="{{route('admin.plan.edit',$item->id)}}">
                                    <i class="las la-pen"></i>
                                </a>
                            </span>
                            @if ($item->status == \App\Models\Plan::ACTIVE)
                                <span data-toggle="tooltip" data-original-title="@lang('Deactive')">
                                    <a class="btn btn-sm bg-yellow-500 hover:bg-yellow-600 text-white" href="{{route('admin.plan.deactive',$item->id)}}">
                                        <i class="las la-ban"></i>
                                    </a>
                                </span>
                            @else 
                                <span data-toggle="tooltip" data-original-title="@lang('Active')">
                                    <a class="btn btn-sm bg-indigo-500 hover:bg-indigo-600 text-white" href="{{route('admin.plan.active',$item->id)}}">
                                        <i class="las la-check-circle"></i>
                                    </a>
                                </span>
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
