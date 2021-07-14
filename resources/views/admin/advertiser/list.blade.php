@extends('admin.layouts.master')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card-header bg-indigo-500">
              <h3 class="card-title text-white">{{__('Advertise List')}}</h3>
              <div class="card-tools">
                <a href="{{route('admin.advertise.create')}}" class="btn btn-sm bg-gray-500 hover:bg-gray-700 text-white"> @lang('Add New') </a>
              </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body table-responsive p-0">
              <table class="table table-head-fixed text-nowrap">
                <thead>
                  <tr>
                    <th> {{__('Name')}} </th>
                    <th>{{__('Ad Type')}}</th>
                    <th>{{__('Impression')}}</th>
                    <th>{{__('Click')}}</th>
                    <th>{{__('Status')}}</th>
                    <th>{{__('Action')}}</th>
                  </tr>
                </thead>
                <tbody>
                    @forelse ($ads as $item)
                    <tr>
                        <td>
                            <span class="font-bold">{{$item->ad_name}}</span> <br>
                        </td>
                        <td>
                            {{$item->ad_type}}
                        </td>
                        <td>
                            <span class="font-bold">
                                {{$item->impression}}
                            </span>
                        </td>
                        <td>
                            {{$item->click}}
                        </td>
                        <td>
                            {{$item->status}}
                        </td>
                        <td>
                            <a href="#0" class="btn btn-sm bg-indigo-500 hover:bg-indigo-700"> @lang('Advertiser Info') </a>
                            <a href="#0" class="btn btn-sm bg-pink-500 hover:bg-pink-700"> @lang('Disable') </a>
                            <a href="#0" class="btn btn-sm bg-green-500 hover:bg-green-700"> @lang('Enable') </a>
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
            <div class="card-footer">
                {{$ads->links()}}
            </div>
          </div>
          <!-- /.card -->
        </div>
      </div>
</div>
@endsection
