@php
$prefix = Request::route()->getPrefix();
$route = Route::current()->getName();

@endphp
@auth
<aside class="main-sidebar sidebar-{{ auth()->user()->sidebar_theam }}-{{ auth()->user()->sidebar_color }} elevation-4">
@endauth
  <!-- Brand Logo -->
  <a href="{{ route('dashboard') }}" class="brand-link">
    <img src="{{ asset('backend/dist/img/top.png') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
    <span class="brand-text font-weight-light">
      <h4><b>USJ</b>Sample</h4>
      {{-- <p style="color:white;font-size:13px;text-align: center;font-weight: bold;">UNIVERSITY OF SRI JAYEWARDENEPURA</p></span> --}}
  </a>

  <!-- Sidebar -->
  <div class="sidebar">
    <!-- Sidebar user panel (optional) -->
    <div class="user-panel mt-2 pb-1 mb-1 d-flex">
      <div class="image">

        <img src="{{ asset('backend/dist/img/profile.jpg') }}" class="" alt="User Image">

      </div>
      <div class="info">
        <a href="" class="d-block">
          @auth
          {{ strtoupper(auth()->user()->name) }}
          @endauth
          <br>
          <span class="" style="font-size: 12px">
            <i class="nav-icon far fa-circle text-success"></i>&nbsp; Online</span>
        </a>

      </div>
    </div>

    <!-- SidebarSearch Form -->
    {{-- <div class="form-inline">
        <div class="input-group" data-widget="sidebar-search">
          <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
          <div class="input-group-append">
            <button class="btn btn-sidebar">
              <i class="fas fa-search fa-fw"></i>
            </button>
          </div>
        </div>
      </div> --}}

    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
        @can('dashbord.view')
        <li class="nav-item menu-open">
          <a href="{{ route('dashboard') }}" class="nav-link {{ $route == 'dashboard'? 'active': '' }}">
            <i class="nav-icon fas fa-tachometer-alt"></i>
            <p>
              Dashboard
            </p>
          </a>

        </li>
        @endcan

        @role('Super-Admin|Admin|User')
        <li class="nav-item">
          <a href="#" class="nav-link {{ $prefix == '/profile'? 'active': '' }}">
            <i class="nav-icon fas fa-user-plus"></i>
            <p>
              Manage Profile
              <i class="fas fa-angle-left right"></i>
              {{-- <span class="badge badge-info right">1</span> --}}
            </p>
          </a>
          @can('perofile.view')
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="{{ route('profile.view') }}" class="nav-link {{ $route == 'profile.view'? 'active': '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Your Profile</p>
              </a>
            </li>
          </ul>
          @endcan
        </li>
        @endrole

        @role('Super-Admin|Admin')
        <li class="nav-item">
          <a href="#" class="nav-link {{ $prefix == '/user'? 'active': '' }}">
            <i class="nav-icon fas fa-users"></i>
            <p>
              Manage Users
              <i class="fas fa-angle-left right"></i>
              {{-- <span class="badge badge-info right">1</span> --}}
            </p>
          </a>
          <ul class="nav nav-treeview">
            @can('user.view')
            <li class="nav-item">
              <a href="{{ route('user.view') }}" class="nav-link {{ $route == 'user.view'? 'active': '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>View Users</p>
              </a>
            </li>
            @endcan
            @can('user.create')
            <li class="nav-item">
              <a href="{{ route('user.add.view') }}" class="nav-link {{ $route == 'user.add.view'? 'active': '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Add New User</p>
              </a>
            </li>
            @endcan
          </ul>
        </li>
        @endrole
        @role('Super-Admin')
        <li class="nav-item">
          <a href="#" class="nav-link {{ $prefix == '/role'? 'active': '' }}">
            <i class="nav-icon fa fa-id-badge"></i>
            <p>
              Role
              <i class="fas fa-angle-left right"></i>
              {{-- <span class="badge badge-info right">1</span> --}}
            </p>
          </a>
          <ul class="nav nav-treeview">
            @can('role.index')
            <li class="nav-item">
              <a href="{{ route('role.index') }}" class="nav-link {{ $route == 'role.index'? 'active': '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Role List</p>
              </a>
            </li>
            @endcan
            @can('role.create')
            <li class="nav-item">
              <a href="{{ route('role.add') }}" class="nav-link {{ $route == 'role.add'? 'active': '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Role Add</p>
              </a>
            </li>
            @endcan
          </ul>
        </li>
        @endrole
        @role('Super-Admin')
        <li class="nav-item">
          <a href="#" class="nav-link {{ $prefix == '/permission'? 'active': '' }}">
            <i class="nav-icon fa fa-lock"></i>
            <p>
              Permission
              <i class="fas fa-angle-left right"></i>
              {{-- <span class="badge badge-info right">1</span> --}}
            </p>
          </a>
          <ul class="nav nav-treeview">
            @can('permission.index')
            <li class="nav-item">
              <a href="{{ route('permission.index') }}" class="nav-link {{ $route == 'permission.index'? 'active': '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Permission List</p>
              </a>
            </li>
            @endcan
            @can('permission.create')
            <li class="nav-item">
              <a href="{{ route('permission.add') }}" class="nav-link {{ $route == 'permission.add'? 'active': '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Permission Add</p>
              </a>
            </li>
            @endcan
          </ul>
        </li>
        @endrole

      @role('Super-Admin|Admin')
      <li class="nav-item">
        <a href="#" class="nav-link {{ $prefix == '/setup'? 'active': '' }}">
          <i class="nav-icon fa fa-cogs"></i>
          <p>
            Setup Management
            <i class="fas fa-angle-left right"></i>
          </p>
        </a>
        <ul class="nav nav-treeview">
            @can('category.type.list')
          <li class="nav-item">
            <a href="{{ route('category.type.index')}}" class="nav-link {{ $route == 'category.type.index'? 'active': '' }}">
              <i class="far fa-circle nav-icon"></i>
              <p>Category Type</p>
            </a>
          </li>
          @endcan
          @can('category.list')
          <li class="nav-item">
            <a href="{{ route('category.index')}}" class="nav-link {{ $route == 'category.index'? 'active': '' }}">
              <i class="far fa-circle nav-icon"></i>
              <p>Category </p>
            </a>
          </li>
          @endcan

        </ul>
    </li>
    @endrole



        <li class="nav-header"></li>
        <li class="nav-item ">
          <a type="button" class="nav-link bg-danger" data-toggle="modal" data-target="#exampleModalCenter">
            <i class="nav-icon fas fa-power-off text-white"></i>
            <p class="text">Logout</p>
          </a>
        </li>
      </ul>
    </nav>
    <!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar -->
</aside>
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalCenterTitle">User Logout</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <h6>Are you realy want to logout system?</h6>
      </div>
      <div class="modal-footer">
        <a type="button" class="btn btn-rounded btn-danger" data-dismiss="modal">Cancel</a>
        <form method="post" action="{{ route('logout') }}">
          @csrf
          <button type="submit" class="btn btn-rounded btn-primary">Logout</button>
        </form>
      </div>
    </div>
  </div>
</div>
