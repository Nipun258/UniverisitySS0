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
              <h3 class="card-title"><a href="{{ URL::previous() }}"><i class="fa fa-arrow-circle-left" aria-hidden="true" style="font-size: 30px;"></i></a> Category Type Add Form</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form method="post" action="{{ route('category.type.store') }}">
              @csrf
              <div class="card-body">
                <div class="row">
                  <div class="col-md-12">
                    <div class="form-group">
                      <label for="">Category Type Name<span class="text-danger"> *</span></label>
                      <input type="text" class="form-control" id="category_type_name" name="category_type_name" value="{{old('category_type_name')}}">
                      <span class="text-danger">@error('category_type_name'){{$message}}@enderror</span>
                    </div>
                    </div><!-- col-md-6 -->
                 </div><!-- row -->

              </div>
                <!-- /.card-body -->
              @can('category.type.create')
              <div class="card-footer">
                @auth
                <input type="submit" class="btn bg-{{ auth()->user()->sidebar_color }}" value="submit" >
                @endauth
                </div>
              @endcan

              </form>
            </div>
            <!-- /.card -->
          </div>
          <!--/.col (left) -->
        </div>
        <!-- /.row -->
    </div><!-- /.container-fluid -->
</section>
      <!-- /.content -->
@endsection
