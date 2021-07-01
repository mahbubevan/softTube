@extends('admin.layouts.master')
@section('content')
<div class="container-fluid">
    <form action="{{route('admin.plan.store')}}" method="post">
        @csrf
        <div class="card">
            <div class="card-header bg-indigo-500 text-white">
                <h4 class="card-title"> @lang('Plan Information') </h4>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="form-group col-md-6">
                        <label for="name"> @lang('Name') <span class="text-pink-700">*</span> </label>
                        <input type="text" id="name" name="name" class="form-control" placeholder="@lang('Your Plan Name')">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="price"> @lang('Price') <span class="text-pink-700">*</span> </label>
                        <input type="text" id="price" name="price" class="form-control" placeholder="@lang('Price For Your Plan')">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="storage"> @lang('Storage') <span class="text-pink-700">*</span> </label>
                        <div class="input-group">
                            <input type="number" id="storage" name="storage" class="form-control" placeholder="@lang('Storage For User')">
                            <select name="storage_unit" required id="storage_unit" class="input-group-text">
                                <option value=""> @lang('Select unit') </option>
                                <option value="{{\App\Models\Plan::MB}}"> @lang('MB') </option>
                                <option value="{{\App\Models\Plan::GB}}"> @lang('GB') </option>
                                <option value="{{\App\Models\Plan::TB}}"> @lang('TB') </option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="storage"> @lang('Storage Type') <span class="text-pink-700">*</span> </label>
                        <select name="storage_type" required id="storage_type" class="form-control">
                            <option value=""> @lang('Select Type') </option>
                            <option value="{{\App\Models\Plan::LOCAL}}"> @lang('Local Disk') </option>
                            <option value="{{\App\Models\Plan::AWS}}"> @lang('Amazon S3') </option>
                        </select>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="type"> @lang('Plan Purchase Type') <span class="text-pink-700">*</span> </label>
                        <select name="type" required id="type" class="form-control">
                            <option value=""> @lang('Select Type') </option>
                            <option value="{{\App\Models\Plan::LIFETIME}}"> @lang('Once Payment For Lifetime') </option>
                            <option value="{{\App\Models\Plan::RECURRING}}"> @lang('Recurring Payment') </option>
                        </select>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="renewal_type"> @lang('Plan Renewal Method') </label>
                        <select disabled name="renewal_type" required id="renewal_type" class="form-control">
                            <option value="{{\App\Models\Plan::MONTHLY}}"> @lang('Monthly') </option>
                            <option value="{{\App\Models\Plan::YEARLY}}"> @lang('Yearly') </option>
                        </select>
                    </div>
                    <div class="form-group col-md-12">
                        <label for="withdrawal_type"> @lang('Withdrawal Method') <span class="text-pink-700">*</span> </label>
                        <select name="withdrawal_type" required id="withdrawal_type" class="form-control">
                            <option value=""> @lang('Select Method') </option>
                            <option value="{{\App\Models\Plan::DAILY}}"> @lang('DAILY') </option>
                            <option value="{{\App\Models\Plan::WEEKLY}}"> @lang('WEEKLY') </option>
                            <option value="{{\App\Models\Plan::MONTHLY}}"> @lang('MONTHLY') </option>
                            <option value="{{\App\Models\Plan::YEARLY}}"> @lang('YEARLY') </option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn float-right bg-indigo-500 hover:bg-indigo-700 text-white">
                    @lang('Add')
                </button>
            </div>
        </div>
    </form>
</div>
@endsection
@push('script')
    <script>
        "use strict"
        $(function(){
            var type = "{{\App\Models\Plan::RECURRING}}"
            $("#type").on("change",function(){
                var currentVal = $(this).val()
                if (currentVal == type) {
                    $("#renewal_type").prop('disabled',false)
                }else{
                    $("#renewal_type").prop('disabled',true)
                }
            })
        
        })
    </script>
@endpush