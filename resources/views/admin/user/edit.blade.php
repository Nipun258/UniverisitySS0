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
              <h3 class="card-title"><a href="{{ URL::previous() }}"><i class="fa fa-arrow-circle-left" aria-hidden="true" style="font-size: 30px;"></i></a> User Edit Form</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form method="post" action="{{ route('user.update',$editData->id) }}" id="roleAddForm">
              @csrf
              <div class="card-body">
                <div class="row">
                  <div class="col-md-12">
                    <div class="form-group">
                      <label for="exampleInputEmail1">Name<span class="text-danger"> *</span></label>
                      <input type="text" class="form-control" id="name" name="name" value="{{ $editData->name}}" >
                      <span class="text-danger">@error('name'){{$message}}@enderror</span>
                    </div>

                    </div><!-- col-md-6 -->
                    {{-- <div class="col-md-6">
                      <div class="form-group">
                        <label for="exampleInputPassword1">Password</label>
                        <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
                      </div>
                      </div><!-- col-md-6 --> --}}
                      </div><!-- row -->
                      <div class="row">
                        <div class="col-md-12">
                          <div class="form-group">
                            <label>Email Address<span class="text-danger"> *</span></label>
                            <input type="email" class="form-control" id="email" name="email" value="{{ $editData->email}}" readonly>
                            <span class="text-danger">@error('email'){{$message}}@enderror</span>
                          </div>
                          {{-- <div class="form-group">
                            <label for="exampleInputFile">File input</label>
                            <div class="input-group">
                              <div class="custom-file">
                                <input type="file" class="custom-file-input" id="exampleInputFile">
                                <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                              </div>
                              <div class="input-group-append">
                                <span class="input-group-text">Upload</span>
                              </div>
                            </div>
                          </div> --}}
                          </div><!-- col-md-6 -->
                          </div><!-- row -->
                            </div>
                            <!-- /.card-body -->
                            @can('user.updation')
                            <div class="card-footer">
                              @auth
                              <input type="submit" class="btn bg-{{ auth()->user()->sidebar_color }}" value="Update" >
                              <a href="{{ route('user.view') }}" class="btn {{ auth()->user()->sidebar_color == 'yellow' ? 'btn-dark' : 'btn-warning'}}">Cancel</a>
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
