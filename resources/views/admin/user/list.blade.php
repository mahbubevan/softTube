@extends('admin.layouts.master')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card-header bg-indigo-500">
              <h3 class="card-title text-white">{{__('Users List')}}</h3>
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
                    <th> {{__('Name')}} | {{__('Username')}} </th>
                    <th>{{__('Email')}} | {{__('Mobile')}}</th>
                    <th>{{__('Balance')}}</th>
                    <th>{{__('Status')}}</th>
                    <th>{{__('Last Login')}}</th>
                    <th>{{__('Action')}}</th>
                  </tr>
                </thead>
                <tbody>
                    @forelse ($users as $item)
                    <tr>
                        <td>
                            <span class="font-bold">{{$item->name}}</span> <br>
                            <span class="font-bold">{{$item->username}}</span>
                        </td>
                        <td>
                            {{$item->email}} <br>
                            {{$item->mobile}}
                        </td>
                        <td>
                            <span class="font-bold">
                                {{number_format($item->balance,2)}} {{__($setting->currency)}}
                            </span>
                        </td>
                        <td>
                            @if ($item->status==0)
                                <span class="badge badge-pill bg-pink-700 text-white p-1"> @lang('Deactive') </span>
                                    @else
                                <span class="badge badge-pill bg-indigo-700 text-white p-1"> @lang('Active') </span>
                            @endif
                        </td>
                        <td>
                            {{$item->updated_at->diffforhumans()}}
                        </td>
                        <td>
                            <a href="{{route('admin.user.show',$item->id)}}" class="btn btn-sm bg-indigo-500 hover:bg-indigo-700 text-white">
                                <i class="las la-eye"></i>
                            </a>
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
                {{$users->links()}}
            </div>
          </div>
          <!-- /.card -->
        </div>
      </div>
</div>
@endsection
