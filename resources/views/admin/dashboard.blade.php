@extends('admin.layouts.master')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner">
                <h3>{{__(number_format(@$company_account->current_balance,2))}}<sup style="font-size: 20px">{{__(@$setting->currency??'BDT')}}</sup></h3>

                <p>{{__('Current Balance')}}</p>
              </div>
              <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
            </div>
          </div>
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
              <div class="inner">
                <h3>{{__(number_format(@$company_account->last_month_balance,2))}}<sup style="font-size: 20px">{{__(@$setting->currency??'BDT')}}</sup></h3>

                <p>{{__('Last Month Balance')}}</p>
              </div>
              <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
            </div>
          </div>

    </div>
    <div class="row">
      <!-- /.col-md-6 -->
      <div class="col-lg-12">
        <div class="card">
          <div class="card-header border-0">
            <div class="d-flex justify-content-between">
              <h3 class="card-title">Sales</h3>
              <a href="javascript:void(0);">View Report</a>
            </div>
          </div>
          <div class="card-body">
            <div class="d-flex">
              <p class="d-flex flex-column">
                {{-- <span class="text-bold text-lg">$18,230.00</span> --}}
                {{-- <span>Sales Over Time</span> --}}
              </p>
              <p class="ml-auto d-flex flex-column text-right">
                <span class="text-success">
                  {{-- <i class="fas fa-arrow-up"></i> 33.1% --}}
                </span>
                {{-- <span class="text-muted">Since last month</span> --}}
              </p>
            </div>
            <!-- /.d-flex -->

            <div class="position-relative mb-4">
              <canvas id="sales-chart" height="200"></canvas>
            </div>

            <div class="d-flex flex-row justify-content-end">
              <span class="mr-2">
                <i class="fas fa-square text-primary"></i> This year
              </span>

              <span>
                <i class="fas fa-square text-gray"></i> Last year
              </span>
            </div>
          </div>
        </div>
        <!-- /.card -->
      </div>
      <!-- /.col-md-6 -->
    </div>
    <!-- /.row -->
  </div>
@endsection
