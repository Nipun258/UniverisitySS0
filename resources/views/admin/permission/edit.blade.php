@extends('admin.admin_master')
@section('admin')
    <!-- Content Header (Page header) -->
    {{-- <section class="content-header">
    <div class="container-fluid">
      <div class="row">
        <div class="col-sm-6">
          <a href="{{ URL::previous() }}"  class="btn btn-danger mb-5">Back</a>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Permission Edit</li>
          </ol>
        </div>
      </div>
      </div><!-- /.container-fluid -->
    </section> --}}
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
                                        aria-hidden="true" style="font-size: 30px;"></i></a> Permission Edit Form</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form method="post" action="{{ route('permission.update', $permission->id) }}">
                            @csrf
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="">Permission Group<span class="text-danger">
                                                    *</span></label>
                                            <select name="permission_group" id="permission_group" class="select2bs4"
                                                style="width: 100%">
                                                <option value="">Select Permission Group</option>
                                                @foreach ($premissionGroups as $category)
                                                    <option value="{{ $category->id }}"
                                                        {{ $category->id == $permission->permission_group_category_id ? 'selected' : '' }}>
                                                        {{ ucfirst(preg_replace('/[_]/', ' ', $category->category_name)) }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <span class="text-danger">
                                                @error('permission_group')
                                                    {{ $message }}
                                                @enderror
                                            </span>
                                        </div>
                                    </div><!-- col-md-6 -->
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Permission Name<span class="text-danger">
                                                    *</span></label>
                                            <input type="text" class="form-control" id="name" name="name"
                                                value="{{ $permission->name }}">
                                            <span class="text-danger">
                                                @error('name')
                                                    {{ $message }}
                                                @enderror
                                            </span>
                                        </div>
                                    </div><!-- col-md-6 -->
                                    {{-- <div class="col-md-6">
                        <div class="form-group">
                          <label for="exampleInputPassword1">Password</label>
                          <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
                        </div>
                      </div><!-- col-md-6 --> --}}
                                </div><!-- row -->

                            </div>
                            <!-- /.card-body -->
                            @can('permission.updation')
                            <div class="card-footer">
                                @auth
                                <input type="submit" class="btn bg-{{ auth()->user()->sidebar_color }}" value="Update">
                                <a href="{{ route('permission.index') }}" class="btn btn-warning">Cancel</a>
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
                            <h3 class="card-title">Role Assign to Permission</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->

                        <form method="post" action="{{ route('permissions.roles', $permission->id) }}">
                            @csrf
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        @if ($permission->roles)
                                            @foreach ($permission->roles as $permission_role)
                                                @can('permission.roles.remove')
                                                <a href="{{ route('permissions.roles.remove', [$permission->id, $permission_role->id]) }}"
                                                    class="btn btn-sm btn-success"
                                                    id="delete">{{ $permission_role->name }} <i
                                                        class="fa fa-times"></i></a>
                                                @endcan
                                            @endforeach
                                        @endif
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Role</label>
                                            <select name="role" id="role_id" class="select2bs4" style="width: 100%;">
                                                <option value="" selected disabled>Select Role</option>
                                                @foreach ($roles as $role)
                                                    <option value="{{ $role->name }}">{{ $role->name }}</option>
                                                @endforeach
                                            </select>
                                            <span class="text-danger">
                                                @error('role')
                                                    {{ $message }}
                                                @enderror
                                            </span>
                                        </div>

                                    </div><!-- col-md-6 -->

                                </div><!-- row -->

                            </div>
                            <!-- /.card-body -->
                            @can('permission.roles.assign')
                            <div class="card-footer">
                                @auth
                                <input type="submit" class="btn bg-{{ auth()->user()->sidebar_color }}" value="Assign">
                                <a href="{{ route('permission.index') }}" class="btn {{ auth()->user()->sidebar_color == 'yellow' ? 'btn-dark' : 'btn-warning'}}">Cancel</a>
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
