@extends('admin.layouts.master')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">{{__('Payments List')}}</h3>
              <div class="card-tools">
                <div class="input-group input-group-sm" style="width: 150px;">
                  <input type="text" name="table_search" class="form-control float-right" placeholder="Search">
                  <div class="input-group-append">
                    <button type="submit" class="btn btn-default"><i class="fas fa-search"></i></button>
                  </div>
                </div>
              </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body table-responsive p-0">
              <table class="table table-head-fixed text-nowrap">
                <thead>
                  <tr>
                    <th> {{__('User')}} </th>
                    <th> {{__('Method')}} </th>
                    <th>{{__('Amount')}} | {{__('Currency')}}</th>
                    <th> {{__('Transaction ID')}} | @lang('PM Type') </th>
                    <th>{{__('Type')}} | {{__('Status')}}</th>
                    <th>{{__('Date')}}</th>
                  </tr>
                </thead>
                <tbody>
                    @forelse ($logs as $item)
                    <tr>
                        <td>
                            <a class="link" href="{{route('admin.user.show',$item->user_id)}}">
                                {{$item->user->name}}
                            </a>
                        </td>
                        <td>
                            {{$item->method->method_name}}
                        </td>
                        <td>
                            {{number_format($item->amount,2)}} <br>
                            {{$item->currency}}
                        </td>
                        <td>
                            {{$item->trx}} <br> <span class="badge bg-gray-500 text-white">{{$item->pm_type}}</span>
                        </td>
                        <td>
                            @if ($item->type==0)
                                <span class="badge bg-indigo-500 text-white"> @lang('Deposit') </span>
                                @else 
                                <span class="badge bg-blue-500 text-white"> @lang('Payment') </span>
                            @endif
                            <br>
                            @if ($item->status==0)
                                <span class="badge bg-pink-500 text-white"> @lang('Failed') </span>
                                @else 
                                <span class="badge bg-green-500 text-white"> @lang('Succeeded') </span>
                            @endif
                        </td>
                        <td>
                            {{\Carbon\Carbon::parse($item->created_at)->format('d F Y')}}
                        </td>
                      </tr>
                    @empty
                      <tr>
                          <td> {{__('No Data')}} </td>
                      </tr>
                    @endforelse
                </tbody>
              </table>
            </div>
            <!-- /.card-body -->
            <div class="card-footer">
                {{$logs->links()}}
            </div>
          </div>
          <!-- /.card -->
        </div>
      </div>
</div>
@endsection
