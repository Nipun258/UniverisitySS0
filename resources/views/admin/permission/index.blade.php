@extends('admin.admin_master')
@section('admin')
<!-- Content Header (Page header) -->


<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Permission List</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Permission</li>
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
                                        <th>Permission Group</th>
                                        <th>Name</th>
                                        <th>Guard</th>
                                        <th width="25%">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($permissions as $key => $permission)
                                    <tr>
                                        <td>{{ $key+1 }}</td>
                                        <td>{{ ucfirst($permission->category_name) }}</td>
                                        <td>{{ $permission->name }}</td>
                                        <td>{{ $permission->guard_name }}</td>

                                        <td>
                                            @can('permission.updation')
                                            <a href="{{ route('permission.edit', $permission->id) }}" class="btn btn-sm btn-info">Edit <i class="fas fa-pencil-alt"></i></a>
                                            @endcan
                                            @can('permission.delete')
                                            <a href="{{ route('permission.delete', $permission->id) }}" class="btn btn-sm btn-danger" id="delete">Delete <i class="fas fa-trash"></i></a>
                                            @endcan
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                                {{-- <tfoot>
                                    <tr>
                                        <th>SN</th>
                                        <th>Emp No</th>
                                        <th>NIC</th>
                                        <th>Name</th>
                                        <th>Phone No</th>
                                        <th>Action</th>
                                    </tr>
                                </tfoot> --}}
                            </table>
                        </div>
                    </div>
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
