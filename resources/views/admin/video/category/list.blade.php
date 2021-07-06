@extends('admin.layouts.master')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
              <div class="card-header bg-indigo-500">
                <h3 class="card-title text-white">{{__('Category')}}</h3>
                <div class="card-tools">
                  <button data-toggle="modal" data-target="#addNew" class="btn bg-green-500 hover:bg-green-700 text-white"> @lang('Add New') </button>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
                <table class="table table-head-fixed text-nowrap">
                  <thead>
                    <tr>
                      <th> {{__('Name')}} </th>
                      <th> {{__('Previous Name')}} </th>
                      <th>{{__('Last Updated')}}</th>
                      <th>{{__('Action')}}</th>
                    </tr>
                  </thead>
                  <tbody>
                      @forelse ($categories as $item)
                      <tr>
                          <td>
                              <span class="font-bold">{{__($item->name)}}</span>
                          </td>
                          <td>
                            <span class="font-bold">{{__($item->previous_name??"N/A")}}</span>
                          </td>
                          <td>
                              <span class="font-bold">
                                  {{$item->updated_at->diffforhumans()}}
                              </span>
                          </td>
                          <td>
                              <a href="#0" data-id="{{$item->id}}" data-name="{{$item->name}}"
                                    class="btn btn-sm bg-indigo-500 hover:bg-indigo-700 text-white edit">
                                  <i class="las la-pen"></i>
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
                  {{$categories->links()}}
              </div>
            </div>
            <!-- /.card -->
        </div>
    </div>
</div>


<!-- Modal -->
<div class="modal fade" id="addNew" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLongTitle"> @lang('Create New Category') </h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action="{{route('admin.video.category.store')}}" method="post">
            @csrf
            <div class="modal-body">
                <div class="row">
                    <div class="form-group col-md-12">
                        <label for="name"> @lang('Name') </label>
                        <input type="text" name="name" id="name" class="form-control" placeholder="@lang('Required')">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-sm btn-dark" data-dismiss="modal"> @lang('Close') </button>
            <button type="button" class="btn btn-sm bg-indigo-500 hover:bg-indigo-700 text-white"> @lang('Create') </button>
            </div>
        </form>
      </div>
    </div>
  </div>

<div class="modal fade" id="editNew" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLongTitle"> @lang('Edit Category') </h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action="{{route('admin.video.category.update')}}" method="post">
            @csrf
            <input type="hidden" name="catId" id="catId">
            <div class="modal-body">
                <div class="row">
                    <div class="form-group col-md-12">
                        <label for="name"> @lang('Name') </label>
                        <input type="text" name="name" id="name" class="form-control" placeholder="@lang('Required')">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-sm btn-dark" data-dismiss="modal"> @lang('Close') </button>
            <button type="submit" class="btn btn-sm bg-indigo-500 hover:bg-indigo-700 text-white"> @lang('Update') </button>
            </div>
        </form>
      </div>
    </div>
  </div>
@endsection
@push('script')
    <script>
        $(function(){
            $(".edit").on('click',function(){
                var modal = $("#editNew").modal()
                modal.find("#catId").val($(this).data('id'))
                modal.find("#name").val($(this).data('name'))
                modal.show()
            })
        })
    </script>
@endpush
