<aside class="main-sidebar sidebar-dark-indigo elevation-4">
    <!-- Brand Logo -->
    <a href="{{route('admin.dashboard')}}" class="brand-link">
      <img src="{{asset(path()['logo']['path'].'/' .$setting->logo)}}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
           style="opacity: .8">
      <span class="brand-text font-weight-light"> {{__($appName)}} </span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="{{asset(path()['admin']['path'].'/' .auth()->guard('admin')->user()->image)}}" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="{{route('admin.profile')}}" class="d-block">{{auth()->guard('admin')->user()->name}}</a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item">
            <a href="{{route('admin.dashboard')}}" class="nav-link @if(request()->routeIs('admin.dashboard')) active @endif">
              <i class="nav-icon las la-home"></i>
              <p>
                {{__('Dashboard')}}
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
          </li>

          <li class="nav-item has-treeview @if(request()->routeIs('admin.user.*')) menu-open @endif">
            <a href="#" class="nav-link @if(request()->routeIs('admin.user.*')) active @endif">
                <i class="nav-icon las la-users"></i>
              <p>
                {{__('Users')}}
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{route('admin.user.list')}}" class="nav-link @if(request()->routeIs('admin.user.list')) active @endif">
                  <i class="far fa-circle nav-icon"></i>
                  <p> {{__('All Users')}} </p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('admin.user.active.list')}}" class="nav-link @if(request()->routeIs('admin.user.active.list')) active @endif">
                  <i class="far fa-circle nav-icon"></i>
                  <p> {{__('Active Users')}} </p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('admin.user.banned.list')}}" class="nav-link @if(request()->routeIs('admin.user.banned.list')) active @endif">
                  <i class="far fa-circle nav-icon"></i>
                  <p> {{__('Banned Users')}} </p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('admin.user.email.unverified.list')}}" class="nav-link @if(request()->routeIs('admin.user.email.unverified.list')) active @endif">
                  <i class="far fa-circle nav-icon"></i>
                  <p> {{__('Email Unverified')}} </p>
                </a>
              </li>

              <li class="nav-item">
                <a href="{{route('admin.user.email.send.all')}}" class="nav-link @if(request()->routeIs('admin.user.email.send.all')) active @endif">
                  <i class="far fa-circle nav-icon"></i>
                  <p> {{__('Send Email To All')}} </p>
                </a>
              </li>

            </ul>
          </li>

          <li class="nav-item">
            <a href="{{route('admin.plan.list')}}" class="nav-link @if(request()->routeIs('admin.plan.*')) active @endif">
              <i class="nav-icon las la-tree"></i>
              <p>
                {{__('Plans')}}
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
          </li>

          <li class="nav-item">
            <a href="{{route('admin.payment.list')}}" class="nav-link @if(request()->routeIs('admin.payment.list')) active @endif">
              <i class="nav-icon las la-cash-register"></i>
              <p>
                {{__('Payments')}}
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
          </li>

          <li class="nav-item">
            <a href="{{route('admin.transaction.list')}}" class="nav-link @if(request()->routeIs('admin.transaction.list')) active @endif">
              <i class="nav-icon las la-exchange-alt"></i>
              <p>
                {{__('Transactions')}}
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{route('admin.email.log')}}" class="nav-link @if(request()->routeIs('admin.email.*')) active @endif">
                <i class="nav-icon las la-inbox"></i>
              <p>
                {{__('Email Logs')}}
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
          </li>

        <li class="nav-header"> @lang('Video Manages') </li>
        <hr class="bg-white">
        <li class="nav-item">
          <a href="{{route('admin.video.category.list')}}" class="nav-link @if(request()->routeIs('admin.video.category.*')) active @endif">
              <i class="nav-icon las la-language"></i>
            <p>
              {{__('Categories')}}
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
        </li>

        <li class="nav-header"> @lang('Application Setting') </li>
          <hr class="bg-white">
          <li class="nav-item">
            <a href="{{route('admin.language.list')}}" class="nav-link @if(request()->routeIs('admin.language.list')) active @endif">
                <i class="nav-icon las la-language"></i>
              <p>
                {{__('Language')}}
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
          </li>

          <li class="nav-item">
            <a href="{{route('admin.setting.index')}}" class="nav-link @if(request()->routeIs('admin.setting.index')) active @endif">
              <i class="nav-icon las la-sliders-h"></i>
              <p>
                {{__('Settings')}}
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
          </li>

          <li class="nav-item">
            <a href="{{route('admin.setting.email')}}" class="nav-link @if(request()->routeIs('admin.setting.email')) active @endif">
                <i class="nav-icon las la-envelope-open-text"></i>
              <p>
                {{__('Email Configure')}}
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
          </li>

          <li class="nav-item">
            <a href="{{route('admin.payment.gateway.list')}}" class="nav-link @if(request()->routeIs('admin.payment.gateway.*')) active @endif">
                <i class="nav-icon las la-credit-card"></i>
              <p>
                {{__('Payment Gateways')}}
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
          </li>

        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>
