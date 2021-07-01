@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col"> @lang('Transaction ID') </th>
                            <th scope="col"> @lang('Amount') </th>
                            <th scope="col"> @lang('Charge') </th>
                            <th scope="col"> @lang('Post Balance') </th>
                            <th scope="col"> @lang('Type') </th>
                            <th scope="col"> @lang('Created At') </th>
                          </tr>
                    </thead>
                    <tbody>
                        @forelse ($payments as $item)
                        <tr>
                            <th scope="row">{{$item->trx}}</th>
                            <td>{{number_format($item->amount,2)}} {{__($setting->currency)}} </td>
                            <td> {{number_format($item->charge,2)}} {{__($setting->currency)}} </td>
                            <td> {{number_format($item->post_balance,2)}} {{__($setting->currency)}} </td>
                            <td> 
                                @if ($item->trx_type==\App\Models\Transaction::CREDIT)
                                    <span class="badge bg-indigo-500"> @lang('CREDITED') </span>
                                    @else 
                                    <span class="badge bg-pink-500"> @lang('DEBITED') </span>
                                @endif    
                            </td>
                            <td>
                                {{$item->created_at->diffforhumans()}}
                            </td>
                        </tr>
                        @empty 
                        <tr>
                            <td class="text-center" colspan="100%"> @lang('No Data') </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
              </div>
        </div>
    </div>
</div>
@endsection