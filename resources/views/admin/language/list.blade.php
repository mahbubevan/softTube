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
                </div>
              </div>
            <div class="card-body table-responsive p-0">
              <table class="table table-head-fixed text-nowrap">
                <thead>
                  <tr>
                    <th> {{__('Name')}} </th>
                    <th>{{__('Code')}} </th>
                    <th>{{__('Text Alignment')}} </th>
                    <th>{{__('Status')}} </th>
                    <th>{{__('Action')}}</th>
                  </tr>
                </thead>
                <tbody>
                    @forelse ($items as $item)
                    <tr>
                        <td>
                            {{$item->name}}
                        <td>
                            {{$item->code}}
                        </td>
                        <td>
                            @if ($item->text_align==0)
                                <span class="badge badge-pill bg-blue-400 text-white"> @lang('Left To Right') </span>
                                @else
                                <span class="badge badge-pill bg-yellow-600 text-white"> @lang('Right To Left') </span>
                            @endif
                        </td>
                        <td>
                            @if ($item->status==1)
                                <span class="badge badge-pill bg-green-800 text-white"> @lang('Default') </span>
                            @endif
                        </td>
                        <td>
                            <a href="#0"
                                data-toggle="tooltip"
                                data-original-title="@lang('Edit')"
                                data-id="{{$item->id}}"
                                data-name="{{$item->name}}"
                                data-code="{{$item->code}}"
                                data-align="{{$item->text_align}}"
                                class="btn btn-sm bg-indigo-500 text-white edit">
                                <i class="las la-pen"></i>
                            </a>
                            <a href="{{route('admin.language.translate.create',$item->id)}}"
                                data-toggle="tooltip"
                                data-original-title="@lang('Translate')"
                                class="btn btn-sm bg-green-400 hover:bg-green-600 text-white">
                                <i class="las la-file-code"></i>
                            </a>
                            <a href="#0"
                                data-toggle="tooltip"
                                data-original-title="@lang('Delete')"
                                data-id="{{$item->id}}"
                                class="btn btn-sm bg-red-500 hover:bg-red-700 text-white delete">
                                <i class="las la-trash"></i>
                            </a>
                            @if ($item->status==0)
                            <a href="{{route('admin.language.default',$item->id)}}"
                                data-toggle="tooltip"
                                data-original-title="@lang('Set As Default')"
                                class="btn btn-sm bg-blue-700 hover:bg-blue-900 text-white">
                                <i class="las la-sync"></i>
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


<!-- Modal -->
<div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel"> @lang('Update Language') </h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action="{{route('admin.language.store')}}" method="POST">
            @csrf
            <div class="modal-body">
                <div class="row">
                    <div class="form-group col-md-12">
                        <label for="name"> @lang('Name') </label>
                        <input id="name" type="text" class="form-control" name="name" placeholder="@lang('Required')">
                    </div>
                    <div class="form-group col-md-12">
                        <label for="code"> @lang('Code') </label>
                        <input id="code" type="text" class="form-control" name="code" placeholder="@lang('Required')">
                    </div>
                    <div class="form-group col-md-12">
                        <label for="text_align"> @lang('Text Alignment') </label>
                        <select name="text_align" id="text_align" class="form-control" required>
                            <option value="0"> {{__("Left To Right Side")}} </option>
                            <option value="1"> {{__("Right To Left Side")}} </option>
                        </select>
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
          <h5 class="modal-title" id="exampleModalLabel"> @lang('Language Delete') </h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action="{{route('admin.language.destroy')}}" method="POST">
            @csrf
            <input type="hidden" name="languageId" id="languageId">
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <h2 class="text-center"> @lang('Are You Sure To Delete') ? </h2>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-sm bg-dark text-white" data-dismiss="modal"> @lang('Close') </button>
              <button type="submit" class="btn btn-sm bg-red-500 hover:bg-red-700 text-white"> @lang('Proceed') </button>
            </div>
        </form>
      </div>
    </div>
</div>

<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel"> @lang('New Language') </h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action="{{route('admin.language.update')}}" method="POST">
            @csrf
            <input type="hidden" name="languageId" id="languageId">
            <div class="modal-body">
                <div class="row">
                    <div class="form-group col-md-12">
                        <label for="name"> @lang('Name') </label>
                        <input id="name" type="text" class="form-control" name="name" placeholder="@lang('Required')">
                    </div>
                    <div class="form-group col-md-12">
                        <label for="code"> @lang('Code') </label>
                        <input id="code" type="text" class="form-control" name="code" placeholder="@lang('Required')">
                    </div>
                    <div class="form-group col-md-12">
                        <label for="text_align"> @lang('Text Alignment') </label>
                        <select name="text_align" id="text_align" class="form-control" required>
                            <option value="0"> {{__("Left To Right Side")}} </option>
                            <option value="1"> {{__("Right To Left Side")}} </option>
                        </select>
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
@endsection

@push('script')
    <script>
        "use strict"
        $(".edit").on("click",function(){
            var modal = $("#editModal").modal()
            var align = $(this).data('align')
            modal.find("#languageId").val($(this).data('id'))
            modal.find("#name").val($(this).data('name'))
            modal.find("#code").val($(this).data('code'))

            modal.find('[name=text_align] option').filter(function() {
                return ($(this).val() == align);
            }).prop('selected', true);

            modal.show()
        })


        $(".delete").on("click",function(){
            var modal = $("#delModal").modal()
            modal.find("#languageId").val($(this).data('id'))
            modal.show()
        })
    </script>
@endpush
