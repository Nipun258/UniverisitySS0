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

                          {{-- Status & SSO Admin row --}}
                          <div class="row">

                            <div class="col-md-6">
                              <div class="form-group">
                                <label>Account Status <span class="text-danger">*</span></label>
                                <div class="d-flex align-items-center mt-1" style="gap:14px;">
                                  <div class="custom-control custom-radio">
                                    <input class="custom-control-input" type="radio" id="status_active"
                                           name="status" value="1"
                                           {{ $editData->status == 1 ? 'checked' : '' }}>
                                    <label class="custom-control-label text-success font-weight-bold"
                                           for="status_active">
                                      <i class="fas fa-check-circle mr-1"></i> Active
                                    </label>
                                  </div>
                                  <div class="custom-control custom-radio">
                                    <input class="custom-control-input" type="radio" id="status_inactive"
                                           name="status" value="0"
                                           {{ $editData->status == 0 ? 'checked' : '' }}>
                                    <label class="custom-control-label text-danger font-weight-bold"
                                           for="status_inactive">
                                      <i class="fas fa-times-circle mr-1"></i> Inactive
                                    </label>
                                  </div>
                                </div>
                              </div>
                            </div>

                            <div class="col-md-6">
                              <div class="form-group">
                                <label>SSO Admin Access</label>
                                <div class="d-flex align-items-center mt-1" style="gap:14px;">
                                  <div class="custom-control custom-radio">
                                    <input class="custom-control-input" type="radio" id="sso_admin_yes"
                                           name="is_sso_admin" value="1"
                                           {{ $editData->is_sso_admin ? 'checked' : '' }}>
                                    <label class="custom-control-label text-danger font-weight-bold"
                                           for="sso_admin_yes">
                                      <i class="fas fa-shield-alt mr-1"></i> Yes — Allow Dashboard
                                    </label>
                                  </div>
                                  <div class="custom-control custom-radio">
                                    <input class="custom-control-input" type="radio" id="sso_admin_no"
                                           name="is_sso_admin" value="0"
                                           {{ !$editData->is_sso_admin ? 'checked' : '' }}>
                                    <label class="custom-control-label font-weight-bold"
                                           for="sso_admin_no">
                                      <i class="fas fa-ban mr-1"></i> No
                                    </label>
                                  </div>
                                </div>
                                <small class="text-muted">Grants access to the SSO Admin Portal (<code>/sso-admin/login</code>)</small>
                              </div>
                            </div>

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
