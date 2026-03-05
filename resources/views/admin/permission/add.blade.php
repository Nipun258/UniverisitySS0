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
          <li class="breadcrumb-item active">Permission Add</li>
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
              <h3 class="card-title"><a href="{{ URL::previous() }}" ><i class="fa fa-arrow-circle-left" aria-hidden="true" style="font-size: 30px;"></i></a> Permission Add Form</h3>
            </div>

            <!-- /.card-header -->
            <!-- form start -->
            <form method="post" action="{{ route('permission.store') }}">
              @csrf
              <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                          <label for="">Permission Group<span class="text-danger"> *</span></label>
                          <select name="permission_group" id="permission_group" class="select2bs4" style="width: 100%">
                            <option value="">Select Permission Group</option>
                            @foreach($premissionGroups as $category)
                            <option value="{{ $category->id}}" {{  $category->id == old('permission_group') ? 'selected' : '' }}>{{ ucfirst(preg_replace('/[_]/', ' ', $category->category_name))}}</option>
                            @endforeach
                        </select>
                          <span class="text-danger">@error('permission_group'){{$message}}@enderror</span>
                        </div>
                        </div><!-- col-md-6 -->
                  <div class="col-md-12">
                    <div class="form-group">
                      <label for="exampleInputEmail1">Permission Name<span class="text-danger"> *</span></label>
                      <input type="text" class="form-control" id="name" name="name" value="{{old('name')}}">
                      <span class="text-danger">@error('name'){{$message}}@enderror</span>
                    </div>
                    </div><!-- col-md-6 -->

                 </div><!-- row -->

              </div>
                <!-- /.card-body -->
                @can('permission.create')
                <div class="card-footer">
                    @auth
                    <input type="submit" class="btn bg-{{ auth()->user()->sidebar_color }}" value="Create" >
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
