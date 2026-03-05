@extends('admin.admin_master')
@section('admin')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">System Users List</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">System Users List</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="box">
                    <!-- /.box-header -->
                    <div class="box-body">
                        <div class="table-responsive">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th width="5%">SN</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        @role('Super-Admin')
                                        <th>Roles</th>
                                        @endrole
                                        <th>Status</th>
                                        <th width="25%">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($users as $key => $user)
                                    <tr>
                                        <td>{{ $key+1 }}</td>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->email }}</td>
                                        @role('Super-Admin')
                                        <td>
                                            @php
                                                $roles = explode(',', $user->roles);
                                                sort($roles); // Sort roles in ascending order
                                                $numberedRoles = collect($roles)->map(function ($role, $index) {
                                                    return sprintf("%02d. %s", $index + 1, ucfirst($role));
                                                })->implode('<br>');
                                            @endphp
                                            {!! $numberedRoles !!}
                                        </td>
                                        @endrole
                                        <td>
                                        @if($user->status == 1)
                                        <span class="badge badge-pill badge-success">Active</span>
                                        @else
                                        <span class="badge badge-pill badge-danger">Inactive</span>
                                        @endif
                                        </td>
                                        <td>
                                            @can('user.show')
                                            <a href="{{ route('user.show',$user->id) }}" class="btn btn-sm btn-success">Show <i class="fa fa-eye"></i></a>
                                            @endcan
                                            @can('user.updation')
                                            <a href="{{ route('user.edit', $user->id) }}" class="btn btn-sm btn-info" id="step-two">Edit <i class="fas fa-pencil-alt"></i></a>
                                            @endcan
                                            @can('user.delete')
                                            <a href="{{ route('user.delete', $user->id) }}" class="btn btn-sm btn-danger" id="delete">Delete <i class="fas fa-trash"></i></a>
                                            @endcan
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
</section>
<!-- /.content -->
@endsection
