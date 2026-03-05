@extends('admin.admin_master')
@section('admin')
{{-- <meta http-equiv="refresh" content="30" /> --}}
<!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Dashboard</h1>

          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Dashboard</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <style>

    </style>
    <br>
    <section class="content">
      <div class="container-fluid">
        <!-- <div class="alert alert-danger" id="success-danger">
          <button type="button" class="close text-white" data-dismiss="alert">x</button>
          <strong>Notice!&nbsp;&nbsp;</strong>
          USJNet Services Tempory unavailable.in case department head functionality may have some dealy.
       </div> -->
        <div class="row">

            <div class="col-lg-3 col-6">
                <!-- small box -->
                @auth
                <div class="small-box bg-{{ auth()->user()->sidebar_color }}">
                @endauth
                  <div class="inner">
                    <h3></h3>

                    <p>Sample Card</p>
                  </div>
                  <div class="icon bg-white">
                    <i class="ion ion-ios-people"></i>
                  </div>
                  <a href="" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>

          <div class="col-lg-3 col-6">
            <!-- small box -->
            @auth
            <div class="small-box bg-{{ auth()->user()->sidebar_color }}">
            @endauth
              <div class="inner">
                <h3></h3>

                <p>Sample Card</p>
              </div>
              <div class="icon bg-white">
                <i class="ion ion-checkmark-round"></i>
              </div>
              <a href="" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>

          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            @auth
            <div class="small-box bg-{{ auth()->user()->sidebar_color }}">
            @endauth
              <div class="inner">
                <h3></h3>

                <p>Sample Card</p>
              </div>
              <div class="icon bg-white">
                <i class="ion ion-clipboard"></i>
              </div>
              <a href="" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>

          <div class="col-lg-3 col-6">
            <!-- small box -->
            @auth
            <div class="small-box bg-{{ auth()->user()->sidebar_color }}">
            @endauth
              <div class="inner">
                <h3></h3>

                <p>Sample Card</p>
              </div>
              <div class="icon bg-white">
                <i class="ion ion-compose"></i>
              </div>
              <a href="" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>



          <!-- ./col -->
        </div>
        <!-- /.row -->
        <div class="row">

            <div class="col-lg-3 col-6">
                <!-- small box -->
                @auth
                <div class="small-box bg-{{ auth()->user()->sidebar_color }}">
                @endauth
                  <div class="inner">
                    <h3></h3>

                    <p>Sample Card</p>
                  </div>
                  <div class="icon bg-white">
                    <i class="ion ion-arrow-graph-up-right"></i>
                  </div>
                  <a href="" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
              </div>
              <!-- ./col -->
              <div class="col-lg-3 col-6">
                <!-- small box -->
                @auth
                <div class="small-box bg-{{ auth()->user()->sidebar_color }}">
                @endauth
                  <div class="inner">
                    <h3></h3>

                    <p>Sample Card</p>
                  </div>
                  <div class="icon bg-white">
                    <i class="ion ion-load-a"></i>
                  </div>
                  <a href="" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
              </div>
            <!-- ./col -->
            <div class="col-lg-3 col-6">
                <!-- small box -->
                @auth
                <div class="small-box bg-{{ auth()->user()->sidebar_color }}">
                @endauth
                  <div class="inner">
                    <h3></h3>

                    <p>Sample Card</p>
                  </div>
                  <div class="icon bg-white">
                    <i class="ion ion-trophy"></i>
                  </div>
                  <a href="" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
              </div>
            <div class="col-lg-3 col-6">
              <!-- small box -->
                @auth
                <div class="small-box bg-{{ auth()->user()->sidebar_color }}">
                @endauth
                <div class="inner">
                  <h3></h3>

                  <p>Sample Card</p>
                </div>
                <div class="icon bg-white">
                  <i class="ion ion-trash-b"></i>
                </div>
                <a href="" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
              </div>
            </div>
            <!-- ./col -->
            {{-- <div class="col-lg-3 col-6">
              <!-- small box -->
              <div class="small-box bg-primary">
                <div class="inner">
                  <h3></h3>

                  <p>Vice Chancellor Pending</p>
                </div>
                <div class="icon bg-white">
                  <i class="ion ion-shuffle"></i>
                </div>
                <a href="" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
              </div>
            </div> --}}

            <!-- ./col -->
          </div>
        <!-- /.row -->

        <!-- Main row -->

        <!-- /.row (main row) -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
@endsection
