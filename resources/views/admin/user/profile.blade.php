@extends('admin.admin_master')
@section('admin')
<style type="text/css">
  .row_panel{
  padding-top: 18px;
  padding-bottom: 5px;

  }
  .main_box_userDetails{
  padding-top: 5px;
  }
  .textStyle{
  font-family:Verdana, Helvetica, sans-serif;
  font-size: 15px;
  }
  </style>
<!-- Main content -->
  <section class="content">

    <div class="row" style="padding: 20px;">

      <div class="col-md-3">
        <div class="card">
          <!-- Profile Image -->
          <div class="card-body">

            <div class="image_area text-center" style="padding-bottom: 20px;">
              <img src="{{ asset('backend/dist/img/profile.jpg') }}" style="width:150px;height: auto;"  class="img-responsive img-circle">
            </div>
            <h3 class="profile-username text-center">{{ $user->name }} </h3>

            <div class="image_area text-center" >
                @if ($user->roles)
                @foreach ($user->roles as $user_role)

                <span class="badge badge-pill badge-dark" style="font-size: 13px;">{{ $user_role->name }} </span>

                @endforeach
                @endif
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>

      </div>

      <!-- /.col -->
      <div class="col-md-8">
        <div class="card">
          <div class="card card-header" style="padding: 10px;">

            <div style="font-family:Verdana, Helvetica, sans-serif;font-size: 25px;margin-left: 20px;"> My Profile</div>
            {{-- <hr style="color: #f03c02;border-top: 3px solid;"> --}}
          </div>
          <div class="main_box_userDetails card-body card-outline card-danger">

            <div class="row row_panel">

                <div class="col-md-3 text-left textStyle" style="color: #f03c02">Employee No</div>
                <div class="col-md-8"><span class="textStyle"> {{ $employee_no }}</span></div>
              </div>
              <div style="border-top: 1px solid #E4E4E3;"> </div>

            <div class="row row_panel">

              <div class="col-md-3 text-left textStyle" style="color: #f03c02;">Name</div>
              <div class="col-md-8"><span  class="textStyle"> {{ $user->name }} </span></div>
            </div>
            <div style="border-top: 1px solid #E4E4E3;"> </div>

            <div class="row row_panel">

              <div class="col-md-3 text-left textStyle" style="color: #f03c02">Email</div>
              <div class="col-md-8"><span class="textStyle"> {{ $user->email }}</span></div>
            </div>
            <div style="border-top: 1px solid #E4E4E3;"> </div>


          </div>

        </div>
        <!-- /.col -->
      </div>
      <div class="col-md-1">
      </div>

    </div>
  </section>
  <!-- /.content -->
<!-- /.content -->
@endsection
