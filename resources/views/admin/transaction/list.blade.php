@extends('admin.layouts.master')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">{{__('Transactions List')}}</h3>
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
                    <th> {{__('Transaction ID')}} </th>
                    <th> {{__('Transaction Type')}} </th>
                    <th>{{__('Amount')}} ({{$setting->currency??"BDT"}})</th>
                    <th>{{__('Post Balance')}} ({{$setting->currency??"BDT"}})</th>
                    <th>{{__('Date')}}</th>
                  </tr>
                </thead>
                <tbody>
                    @forelse ($logs as $item)
                    <tr>
                        <td>
                            {{$item->trx}}
                        </td>
                        <td>
                            @if ($item->trx_type==\App\Models\Transaction::DEBIT)
                                <span class="badge badge-danger">{{__('DEBITED')}}</span>
                                @else
                                <span class="badge badge-success">{{__('CREDITED')}}</span>
                            @endif
                        </td>
                        <td>
                            <span
                            class="@if($item->trx_type==\App\Models\Transaction::DEBIT) text-danger @else text-success @endif"
                            >
                                {{number_format($item->amount,2)}}
                            </span>
                        </td>
                        <td>
                            {{number_format($item->post_balance,2)}}
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
