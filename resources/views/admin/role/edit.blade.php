@extends('admin.admin_master')
@section('admin')
    <!-- Content Header (Page header) -->
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <!-- left column -->
                <div class="col-md-12">
                    <!-- general form elements -->
                    @auth
                    <div class="card card-{{ auth()->user()->sidebar_color }}">
                    @endauth
                        <div class="card-header">
                            <h3 class="card-title"><a href="{{ URL::previous() }}"><i class="fa fa-arrow-circle-left"
                                        aria-hidden="true" style="font-size: 30px;"></i></a> Role Edit Form</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form method="post" action="{{ route('role.update', $role->id) }}" id="roleAddForm">
                            @csrf
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Role Name<span class="text-danger">
                                                    *</span></label>
                                            <input type="text" class="form-control" id="name" name="name"
                                                value="{{ $role->name }}">
                                            <span class="text-danger">
                                                @error('name')
                                                    {{ $message }}
                                                @enderror
                                            </span>
                                        </div>

                                    </div>
                                </div><!-- row -->
                            </div>
                            <!-- /.card-body -->
                            @can('role.updation')
                            <div class="card-footer">
                                @auth
                                <input type="submit" class="btn bg-{{ auth()->user()->sidebar_color }}" value="Update">
                                <a href="{{ route('role.index') }}" class="btn {{ auth()->user()->sidebar_color == 'yellow' ? 'btn-dark' : 'btn-warning'}}">Cancel</a>
                                @endauth
                            </div>
                            @endcan
                        </form>
                    </div>
                    <!-- /.card -->
                    @auth
                    <div class="card card-{{ auth()->user()->sidebar_color }}">
                    @endauth
                        <div class="card-header">
                            <h3 class="card-title">Permission Assign Role</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->

                        <form method="post" action="{{ route('role.permission.update', $role->id) }}">
                            @csrf
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        @if ($role->permissions)
                                            @foreach ($role->permissions as $role_permission)
                                               @can('role.permissions.revoke')
                                                <a href="{{ route('roles.permissions.revoke', [$role->id, $role_permission->id]) }}"
                                                    class="btn btn-sm btn-success"
                                                    id="delete">{{ $role_permission->name }} <i
                                                        class="fa fa-times"></i></a>
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
                                                @foreach ($premissions as $permission)
                                                    <option value="{{ $permission->name }}">{{ $permission->name }}</option>
                                                @endforeach
                                            </select>
                                            <span class="text-danger">
                                                @error('permission')
                                                    {{ $message }}
                                                @enderror
                                            </span>
                                        </div>

                                    </div><!-- col-md-6 -->

                                </div><!-- row -->

                            </div>
                            <!-- /.card-body -->
                            @can('role.permission.update')
                            <div class="card-footer">
                                @auth
                                <input type="submit" class="btn bg-{{ auth()->user()->sidebar_color }}" value="Assign">
                                <a href="{{ route('role.index') }}" class="btn {{ auth()->user()->sidebar_color == 'yellow' ? 'btn-dark' : 'btn-warning'}}">Cancel</a>
                                @endauth
                            </div>
                            @endcan
                        </form>
                    </div>
                </div>
                <!--/.col (left) -->
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
@endsection
