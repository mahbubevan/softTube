@extends('admin.layouts.master')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header bg-indigo-500">
                <h3 class="card-title text-white">{{__('Manage Language')}}</h3>
                <div class="card-tools">
                  <button data-toggle="modal" data-target="#addModal" class="btn btn-sm bg-dark"> @lang('Add New') </button>
                  <a href="{{route('admin.language.list')}}" class="btn btn-sm bg-blue-800 hover:bg-blue-900 text-white"> @lang('Go Back') </a href="{{route('admin.language.list')}}">
                </div>
              </div>
            <div class="card-body table-responsive p-0">
              <table class="table table-head-fixed text-nowrap">
                <thead>
                  <tr>
                    <th> {{__('Key')}} </th>
                    <th>{{__('Translated')}} </th>
                    <th>{{__('Action')}}</th>
                  </tr>
                </thead>
                <tbody>
                    @forelse ($translates as $key=>$item)
                    <tr>
                        <td>
                            {{$key}}
                        <td>
                            {{$item}}
                        </td>
                        <td>
                            <a href="#0"
                                data-toggle="tooltip"
                                data-original-title="@lang('Edit')"
                                data-key="{{$key}}"
                                data-translate="{{$item}}"
                                class="btn btn-sm bg-indigo-500 text-white edit">
                                <i class="las la-pen"></i>
                            </a>
                            <a href="#0"
                                data-toggle="tooltip"
                                data-original-title="@lang('Remove')"
                                data-key="{{$key}}"
                                class="btn btn-sm bg-red-500 hover:bg-red-700 text-white delete">
                                <i class="las la-trash"></i>
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
          </div>
          <!-- /.card -->
        </div>
      </div>
</div>


<div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel"> @lang('Translate Language') </h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action="{{route('admin.language.translate.update',$lang->id)}}" method="POST">
            @csrf
            <div class="modal-body">
                <div class="row">
                    <div class="form-group col-md-12">
                        <label for="key"> @lang('Key') </label>
                        <input id="key" type="text" class="form-control" name="key" required placeholder="@lang('Required')">
                    </div>
                    <div class="form-group col-md-12">
                        <label for="translate"> @lang('Translation') </label>
                        <input id="translate" type="text" class="form-control" name="translate" required placeholder="@lang('Required')">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-sm bg-dark text-white" data-dismiss="modal"> @lang('Close') </button>
              <button type="submit" class="btn btn-sm bg-indigo-500 text-white"> @lang('Proceed') </button>
            </div>
        </form>
      </div>
    </div>
</div>

<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel"> @lang('Edit Translate Language') </h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action="{{route('admin.language.translate.key.update',$lang->id)}}" method="POST">
            @csrf
            <div class="modal-body">
                <div class="row">
                    <div class="form-group col-md-12">
                        <label for="key"> @lang('Key') </label>
                        <input id="key" readonly type="text" class="form-control" name="key" required placeholder="@lang('Required')">
                    </div>
                    <div class="form-group col-md-12">
                        <label for="translate"> @lang('Translation') </label>
                        <input id="translate" type="text" class="form-control" name="translate" required placeholder="@lang('Required')">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-sm bg-dark text-white" data-dismiss="modal"> @lang('Close') </button>
              <button type="submit" class="btn btn-sm bg-indigo-500 text-white"> @lang('Proceed') </button>
            </div>
        </form>
      </div>
    </div>
</div>

<div class="modal fade" id="delModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel"> @lang('Delete Translate Language') </h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action="{{route('admin.language.translate.key.destroy',$lang->id)}}" method="POST">
            @csrf
            <div class="modal-body">
                <input id="key" readonly type="hidden" class="form-control" name="key" required placeholder="@lang('Required')">
                <div class="row">
                    <div class="col-md-12">
                        <h3 class="font-bold text-center"> @lang('Are you sure to delete') <span class="keyText text-indigo-500"></span> ? </h3>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-sm bg-dark text-white" data-dismiss="modal"> @lang('Close') </button>
              <button type="submit" class="btn btn-sm bg-red-500 hover:bg-red-900 text-white"> @lang('Proceed') </button>
            </div>
        </form>
      </div>
    </div>
</div>
@endsection
@push('script')
    <script>
        $(".edit").on("click",function(){
            var modal = $("#editModal").modal()
            modal.find("#key").val($(this).data('key'))
            modal.find("#translate").val($(this).data('translate'))
            modal.show()
        })

        $(".delete").on("click",function(){
            var modal = $("#delModal").modal()
            modal.find("#key").val($(this).data('key'))
            modal.find(".keyText").text($(this).data('key'))
            modal.show()
        })

    </script>
@endpush
