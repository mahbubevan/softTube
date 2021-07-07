@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="table-responsive">
                <table class="table">
                    <thead class="bg-indigo-500 text-white">
                        <tr>
                            <th scope="col"> @lang('Title') </th>
                            <th scope="col"> @lang('Size') </th>
                            <th scope="col"> @lang('Watched') </th>
                            <th scope="col"> @lang('Subscribed') </th>
                            <th scope="col"> @lang('Liked') </th>
                            <th scope="col"> @lang('Action') </th>
                          </tr>
                    </thead>
                    <tbody>
                      @forelse ($videos as $item)
                          <tr>
                              <td> {{__($item->title)}} </td>
                              <td>
                                  {{number_format($item->size)}} @lang('Bytes')
                              </td>
                              <td></td>
                              <td></td>
                              <td></td>
                              <td>
                                  <a href="#0" class="btn btn-sm bg-indigo-500 hover:bg-indigo-700 text-white">
                                    <i class="las la-pen"></i>
                                  </a>
                              </td>
                          </tr>
                      @empty
                          <tr>
                              <td colspan="100%" class="text-center"> @lang('No Data') </td>
                          </tr>
                      @endforelse
                    </tbody>
                  </table>
              </div>
        </div>
    </div>
</div>
@endsection