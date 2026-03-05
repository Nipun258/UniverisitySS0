@extends('admin.admin_master')
@section('admin')
{{-- <div class="content-wrapper"> --}}
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h3>User Details</h3>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">User Details</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="card">
        {{-- <div class="card-header">
          <h3 class="card-title">Booking Details</h3>

          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
              <i class="fas fa-minus"></i>
            </button>
            <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
              <i class="fas fa-times"></i>
            </button>
          </div>
        </div> --}}
        <div class="card-body">
          <div class="row">
            <div class="col-12 col-md-12 order-2 order-md-1">
              <div class="row">
                <div class="col-12 col-md-3">
                  <div class="info-box bg-light">
                    <div class="info-box-content">
                      <span class="info-box-text text-center text-muted">User ID</span>
                      <span class="info-box-number text-center text-muted mb-0">{{ str_pad($user->id, 3, '0', STR_PAD_LEFT) }}</span>
                    </div>
                  </div>
                </div>
                <div class="col-12 col-md-3">
                  <div class="info-box bg-light">
                    <div class="info-box-content">
                      <span class="info-box-text text-center text-muted">Name</span>
                      <span class="info-box-number text-center text-muted mb-0">{{ $user->name }}</span>
                    </div>
                  </div>
                </div>
                <div class="col-12 col-md-3">
                  <div class="info-box bg-light">
                    <div class="info-box-content">
                      <span class="info-box-text text-center text-muted">Email</span>
                      <span class="info-box-number text-center text-muted mb-0">{{ $user->email }}</span>
                    </div>
                  </div>
                </div>
                <div class="col-12 col-md-3">
                    <div class="info-box bg-light">
                      <div class="info-box-content">
                        <span class="info-box-text text-center text-muted">Status</span>
                        <span class="info-box-number text-center text-muted mb-0">@if ($user->status == 1)
                            <span class="badge badge-pill badge-success" style="font-size: 12px;">Active</span>
                            @else
                            <span class="badge badge-pill badge-danger" style="font-size: 12px;">Inactive</span>
                            @endif
                        </span>
                      </div>
                    </div>
                  </div>
              </div>

            </div>
          </div>

        </div>
        <!-- /.card-body -->
      </div>
      <!-- /.card -->

       @auth
        <div class="card card-{{ auth()->user()->sidebar_color }}">
       @endauth
        <div class="card-header">
          <h3 class="card-title">Role Assign to User</h3>
        </div>
        <!-- /.card-header -->
        <!-- form start -->

        <form method="post" action="{{ route('users.roles',$user->id) }}" >
          @csrf
          <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    @if ($user->roles)
                    @foreach ($user->roles as $user_role)
                    @if ($user_role->name != 'User')
                    @can('user.roles.remove')
                        <a href="{{ route('users.roles.remove', [$user->id, $user_role->id]) }}" class="btn btn-sm btn-success" id="delete">{{ $user_role->name }} <i class="fa fa-times"></i></a>
                    @endcan
                    @else
                    <button type="button" class="btn btn-sm btn-dark">{{ $user_role->name }} </button>
                    @endif
                    @endforeach
                    @endif
                </div>
            </div>
            <div class="row mt-3">
              <div class="col-md-12">
                <div class="form-group">
                    <label>Role</label>
                    <select name="role" id="role_id" class="select2bs4"
                            style="width: 100%;">
                    <option value="" selected disabled>Select Role</option>
                      @foreach ($roles as $role)
                        <option value="{{ $role->name }}">{{ $role->name }}</option>
                        @endforeach
                    </select>
                    <span class="text-danger">@error('role'){{$message}}@enderror</span>
                  </div>

                </div><!-- col-md-6 -->

            </div><!-- row -->

                        </div>
                        <!-- /.card-body -->
                        @can('user.roles.assign')
                        <div class="card-footer">
                        @auth
                        <input type="submit" class="btn bg-{{ auth()->user()->sidebar_color }}" value="Assign" >
                        <a href="{{ route('user.view') }}" class="btn {{ auth()->user()->sidebar_color == 'yellow' ? 'btn-dark' : 'btn-warning'}}">Cancel</a>
                        @endauth
                        </div>
                        @endcan
                      </form>
                    </div>

                    @auth
                    <div class="card card-{{ auth()->user()->sidebar_color }}">
                    @endauth
        <div class="card-header">
          <h3 class="card-title">Permission Assign to User</h3>
        </div>
        <!-- /.card-header -->
        <!-- form start -->

        <form method="post" action="{{ route('users.permissions',$user->id) }}" >
          @csrf
          <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    @if ($user->permissions)
                    @foreach ($user->permissions as $user_permission)
                    @can('user.permissions.revoke')
                        <a href="{{ route('users.permissions.revoke', [$user->id, $user_permission->id]) }}" class="btn btn-sm btn-success" id="delete">{{ $user_permission->name }} <i class="fa fa-times"></i></a>
                    @endcan
                    @endforeach
                    @endif
                </div>
            </div>
            <div class="row mt-3">
              <div class="col-md-12">
                <div class="form-group">
                    <label>Permission</label>
                    <select name="permission" id="permission_id" class="select2bs4"
                            style="width: 100%;">
                      <option value="" selected disabled>Select Permission</option>
                      @foreach ($permissions as $permission)

                        <option value="{{ $permission->name }}">{{ $permission->name }}</option>
                        @endforeach
                    </select>
                    <span class="text-danger">@error('permission'){{$message}}@enderror</span>
                  </div>

                </div><!-- col-md-6 -->

            </div><!-- row -->

                        </div>
                        <!-- /.card-body -->
                        @can('user.permissions.assign')
                        <div class="card-footer">
                        @auth
                          <input type="submit" class="btn bg-{{ auth()->user()->sidebar_color }}" value="Assign" >
                          <a href="{{ route('user.view') }}" class="btn {{ auth()->user()->sidebar_color == 'yellow' ? 'btn-dark' : 'btn-warning'}}">Cancel</a>
                        @endauth
                        </div>
                        @endcan
                      </form>
                    </div>

    </section>
    <!-- /.content -->
  {{-- </div> --}}
@endsection
