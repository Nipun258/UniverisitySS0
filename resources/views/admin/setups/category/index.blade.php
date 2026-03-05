@extends('admin.admin_master')
@section('admin')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Category List</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Category</li>
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
                    <div class="box-header with-border">
                        <div class="row">
                            <div class="col-md-12">
                                @can('category.create')
                                @auth
                                <a href="{{ route('category.add') }}" style="float: right;" class="btn  bg-{{ auth()->user()->sidebar_color }} mb-5">Add Category</a>
                                @endauth
                                @endcan
                            </div>
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <div class="table-responsive">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th width="5%">SN</th>
                                        <th>Category ID</th>
                                        <th>Category Type</th>
                                        <th>Category</th>
                                        <th>Category Code</th>
                                        <th>Sorting Order</th>
                                        <th width="30%">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($categories as $key => $category)
                                    <tr>
                                        <td>{{ $key+1 }}</td>
                                        <td>{{ $category->id }}</td>
								        <td>{{ ucfirst(preg_replace('/[_]/', ' ', $category->name)) }}</td>
								        <td>{{ ucfirst($category->category_name) }}</td>
                                        <td>{{ $category->category_code }}</td>
                                        <td>{{ $category->sorting_order }}</td>
                                        <td>
                                            @can('category.updation')
                                            <a href="{{ route('category.edit', $category->id) }}" class="btn btn-sm btn-info">Edit <i class="fas fa-pencil-alt"></i></a>
                                            @endcan
                                            @can('category.delete')
                                            <a href="{{ route('category.delete', $category->id) }}" class="btn btn-sm btn-danger" id="delete">Delete <i class="fas fa-trash"></i></a>
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
