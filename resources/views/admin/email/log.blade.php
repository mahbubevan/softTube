@extends('admin.layouts.master')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header bg-indigo-500">
              <h3 class="card-title text-white">{{__('All Emails')}}</h3>
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
                    <th> {{__('Send To')}} | {{__('Username')}} </th>
                    <th>{{__('Mailer Method')}}</th>
                    <th>{{__('Subject')}}</th>
                    <th>{{__('Send At')}}</th>
                    <th>{{__('Action')}}</th>
                  </tr>
                </thead>
                <tbody>
                    @forelse ($logs as $item)
                    <tr>
                        <td>
                            {{$item->to}} <br>
                            <a class="badge badge-pill bg-indigo-500 text-white" href="{{route('admin.user.show',$item->user_id)}}">
                                {{$item->user->username}}
                            </a>
                        </td>
                        <td>
                            {{$item->mail_sender}}
                        </td>
                        <td>
                            {{$item->subject}}
                        </td>
                        <td>
                            {{$item->created_at->diffforhumans()}}
                        </td>
                        <td>
                            <a href="{{route('admin.email.show',$item->id)}}" class="btn btn-sm bg-indigo-500 hover:bg-indigo-700 text-white">
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
                {{$logs->links()}}
            </div>
          </div>
          <!-- /.card -->
        </div>
      </div>
</div>
@endsection
