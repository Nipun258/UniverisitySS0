@extends('admin.admin_master')
@section('admin')
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
              <h3 class="card-title"><a href="{{ URL::previous() }}"><i class="fa fa-arrow-circle-left" aria-hidden="true" style="font-size: 30px;"></i></a> User Add Form</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form method="post" action="{{ route('user.store') }}" id="roleAddForm">
              @csrf
              <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                          <label>Employee</label>
                          <select name="empno" id="empno" class="select2bs4" style="width: 100%;">
                            <option value="" selected disabled>Select Employee</option>
                            @foreach ($empData as $emp)
                                <option value="{{ $emp['employee_no'] }}|{{ $emp['email'] }} |{{ $emp['last_name'] }} | {{ $emp['initials'] }}">
                                    {{ $emp['employee_no'] }} - {{ $emp['initials'] }} {{ $emp['last_name'] }} - ( {{ $emp['email'] }} )
                                </option>
                            @endforeach
                        </select>
                          <span class="text-danger">@error('role'){{$message}}@enderror</span>
                        </div>

                      </div><!-- col-md-6 -->

                  </div><!-- row -->

                          <div class="row">
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
                            @can('user.create')
                            <div class="card-footer">
                              @auth
                              <input type="submit" class="btn bg-{{ auth()->user()->sidebar_color }}" value="Submit" >
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
