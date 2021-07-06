@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header bg-indigo-500 text-white">
                    <h4 class="card-title"> @lang('Balance') </h4>
                </div>
                <div class="card-body">
                    {{number_format(auth()->user()->balance,2)}} {{__($setting->currency)}}
                </div>
            </div>
        </div>
    </div>
    <div class="row justify-content-center mt-5 mb-5">
        @forelse ($videos as $item)
        <div class="col-md-4">
            <div class="card">
                <div class="card-header bg-green-500 text-white">
                    <h4 class="card-title"> @lang(__($item->title)) </h4>
                </div>
                <div class="card-body">
                    <video width="100%" height="240" controls>
                        <source src="{{asset($item->path)}}" type="video/mp4">
                    </video>
                </div>
            </div>
        </div>
        @empty
            <span class="h1"> @lang('No Video Uploaded') </span>
        @endforelse
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel"> @lang('Deposit Amount') </h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form action="{{route('user.deposit.money')}}" method="post">
            @csrf
            <div class="modal-body">
                <div class="row">
                    <div class="form-group col-md-12">
                        <label for="amount"> @lang('Amount') </label>
                        <div class="input-group">
                            <input type="number" step="any" name="amount" class="form-control" />
                            <span class="input-group-text"> {{__($setting->currency)}} </span>
                        </div>
                    </div>
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn bg-dark text-white" data-bs-dismiss="modal"> @lang('Close') </button>
                <button type="submit" class="btn bg-indigo-500 hover:bg-indigo-700 text-white"> @lang('Proceed') </button>
              </div>
        </form>
      </div>
    </div>
  </div>
@endsection
