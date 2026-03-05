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
              <h3 class="card-title">Interface Customization Setting</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form method="post" action="{{ route('site.settings.update') }}" id="siteSettingsForm">
              @csrf
              <div class="card-body">
                <div class="row">
                  <!-- Dark Mode -->
                  <div class="col-md-6">
                    <div class="form-group">
                      <label>Dark Mode</label>
                      <select name="dark_mode" class="form-control select2bs4">
                        <option value="0" {{ old('dark_mode', auth()->user()->dark_mode) == 0 ? 'selected' : '' }}>Disabled</option>
                        <option value="1" {{ old('dark_mode', auth()->user()->dark_mode) == 1 ? 'selected' : '' }}>Enabled</option>
                      </select>
                      <span class="text-danger">@error('dark_mode'){{ $message }}@enderror</span>
                    </div>
                  </div>

                  <!-- Sidebar Theme -->
                  <div class="col-md-6">
                    <div class="form-group">
                      <label>Sidebar Theme</label>
                      <select name="sidebar_theam" class="form-control select2bs4">
                        <option value="dark" {{ old('sidebar_theam', auth()->user()->sidebar_theam) == 'dark' ? 'selected' : '' }}>Dark</option>
                        <option value="light" {{ old('sidebar_theam', auth()->user()->sidebar_theam) == 'light' ? 'selected' : '' }}>Light</option>
                      </select>
                      <span class="text-danger">@error('sidebar_theam'){{ $message }}@enderror</span>
                    </div>
                  </div>

                  <!-- Sidebar Color -->
                  <div class="col-md-6">
                    <div class="form-group">
                      <label>Sidebar Color</label>
                      <select name="sidebar_color" class="form-control select2bs4">
                        <option value="primary" {{ old('sidebar_color', auth()->user()->sidebar_color) == 'primary' ? 'selected' : '' }}>Blue</option>
                        <option value="secondary" {{ old('sidebar_color', auth()->user()->sidebar_color) == 'secondary' ? 'selected' : '' }}>Secondary</option>
                        <option value="success" {{ old('sidebar_color', auth()->user()->sidebar_color) == 'success' ? 'selected' : '' }}>Green</option>
                        <option value="cyan" {{ old('sidebar_color', auth()->user()->sidebar_color) == 'cyan' ? 'selected' : '' }}>Cyan</option>
                        <option value="yellow" {{ old('sidebar_color', auth()->user()->sidebar_color) == 'yellow' ? 'selected' : '' }}>Yellow</option>
                        <option value="red" {{ old('sidebar_color', auth()->user()->sidebar_color) == 'red' ? 'selected' : '' }}>Red</option>
                        <option value="black" {{ old('sidebar_color', auth()->user()->sidebar_color) == 'black' ? 'selected' : '' }}>Black</option>
                        <option value="gray-dark" {{ old('sidebar_color', auth()->user()->sidebar_color) == 'gray-dark' ? 'selected' : '' }}>Dark Gray</option>
                        <option value="gray" {{ old('sidebar_color', auth()->user()->sidebar_color) == 'gray' ? 'selected' : '' }}>Gray</option>
                        <option value="light" {{ old('sidebar_color', auth()->user()->sidebar_color) == 'light' ? 'selected' : '' }}>Light</option>
                        <option value="indigo" {{ old('sidebar_color', auth()->user()->sidebar_color) == 'indigo' ? 'selected' : '' }}>Indigo</option>
                        <option value="navy" {{ old('sidebar_color', auth()->user()->sidebar_color) == 'navy' ? 'selected' : '' }}>Navy Blue</option>
                        <option value="purple" {{ old('sidebar_color', auth()->user()->sidebar_color) == 'purple' ? 'selected' : '' }}>Purple</option>
                        <option value="fuchsia" {{ old('sidebar_color', auth()->user()->sidebar_color) == 'fuchsia' ? 'selected' : '' }}>Fuchsia</option>
                        <option value="pink" {{ old('sidebar_color', auth()->user()->sidebar_color) == 'pink' ? 'selected' : '' }}>Pink</option>
                        <option value="maroon" {{ old('sidebar_color', auth()->user()->sidebar_color) == 'maroon' ? 'selected' : '' }}>Maroon</option>
                        <option value="orange" {{ old('sidebar_color', auth()->user()->sidebar_color) == 'orange' ? 'selected' : '' }}>Orange</option>
                        <option value="lime" {{ old('sidebar_color', auth()->user()->sidebar_color) == 'lime' ? 'selected' : '' }}>lime</option>
                        <option value="teal" {{ old('sidebar_color', auth()->user()->sidebar_color) == 'teal' ? 'selected' : '' }}>Teal</option>
                        <option value="olive" {{ old('sidebar_color', auth()->user()->sidebar_color) == 'olive' ? 'selected' : '' }}>Olive</option>
                      </select>
                      <span class="text-danger">@error('sidebar_color'){{ $message }}@enderror</span>
                    </div>
                  </div>

                  <!-- Sidebar Layout -->
                  <div class="col-md-6">
                    <div class="form-group">
                      <label>Sidebar Layout</label>
                      <select name="sidebar_layout" class="form-control select2bs4">
                        <option value="layout-fixed" {{ old('sidebar_layout', auth()->user()->sidebar_layout) == 'layout-fixed' ? 'selected' : '' }}>Fixed Sidebar</option>
                        <option value="sidebar-collapse" {{ old('sidebar_layout', auth()->user()->sidebar_layout) == 'sidebar-collapse' ? 'selected' : '' }}>Collapse Sidebar</option>
                      </select>
                      <span class="text-danger">@error('sidebar_layout'){{ $message }}@enderror</span>
                    </div>
                  </div>

                  <!-- Navbar Color -->
                  <div class="col-md-6">
                    <div class="form-group">
                      <label>Navbar Color</label>
                      <select name="nav_color" class="form-control select2bs4">
                        <option value="navbar-primary" {{ old('nav_color', auth()->user()->nav_color) == 'navbar-primary' ? 'selected' : '' }}>Blue</option>
                        <option value="navbar-secondary" {{ old('nav_color', auth()->user()->nav_color) == 'navbar-secondary' ? 'selected' : '' }}>Secondary</option>
                        <option value="navbar-success" {{ old('nav_color', auth()->user()->nav_color) == 'navbar-success' ? 'selected' : '' }}>Green</option>
                        <option value="navbar-cyan" {{ old('nav_color', auth()->user()->nav_color) == 'navbar-cyan' ? 'selected' : '' }}>Cyan</option>
                        <option value="navbar-yellow" {{ old('nav_color', auth()->user()->nav_color) == 'navbar-yellow' ? 'selected' : '' }}>Yellow</option>
                        <option value="navbar-red" {{ old('nav_color', auth()->user()->nav_color) == 'navbar-red' ? 'selected' : '' }}>Red</option>
                        <option value="navbar-black" {{ old('nav_color', auth()->user()->nav_color) == 'navbar-black' ? 'selected' : '' }}>Black</option>
                        <option value="navbar-gray-dark" {{ old('nav_color', auth()->user()->nav_color) == 'navbar-gray-dark' ? 'selected' : '' }}>Dark Gray</option>
                        <option value="navbar-gray" {{ old('nav_color', auth()->user()->nav_color) == 'navbar-gray' ? 'selected' : '' }}>Gray</option>
                        <option value="navbar-white" {{ old('nav_color', auth()->user()->nav_color) == 'navbar-white' ? 'selected' : '' }}>White</option>
                        <option value="navbar-indigo" {{ old('nav_color', auth()->user()->nav_color) == 'navbar-indigo' ? 'selected' : '' }}>Indigo</option>
                        <option value="navbar-navy" {{ old('nav_color', auth()->user()->nav_color) == 'navbar-navy' ? 'selected' : '' }}>Navy Blue</option>
                        <option value="navbar-purple" {{ old('nav_color', auth()->user()->nav_color) == 'navbar-purple' ? 'selected' : '' }}>Purple</option>
                        <option value="navbar-fuchsia" {{ old('nav_color', auth()->user()->nav_color) == 'navbar-fuchsia' ? 'selected' : '' }}>Fuchsia</option>
                        <option value="navbar-pink" {{ old('nav_color', auth()->user()->nav_color) == 'navbar-pink' ? 'selected' : '' }}>Pink</option>
                        <option value="navbar-maroon" {{ old('nav_color', auth()->user()->nav_color) == 'navbar-maroon' ? 'selected' : '' }}>Maroon</option>
                        <option value="navbar-orange" {{ old('nav_color', auth()->user()->nav_color) == 'navbar-orange' ? 'selected' : '' }}>Orange</option>
                        <option value="navbar-lime" {{ old('nav_color', auth()->user()->nav_color) == 'navbar-lime' ? 'selected' : '' }}>lime</option>
                        <option value="navbar-teal" {{ old('nav_color', auth()->user()->nav_color) == 'navbar-teal' ? 'selected' : '' }}>Teal</option>
                        <option value="navbar-olive" {{ old('nav_color', auth()->user()->nav_color) == 'navbar-olive' ? 'selected' : '' }}>Olive</option>
                      </select>
                      <span class="text-danger">@error('nav_color'){{ $message }}@enderror</span>
                    </div>
                  </div>

                  <!-- Navbar Layout -->
                  <div class="col-md-6">
                    <div class="form-group">
                      <label>Navbar Layout</label>
                      <select name="nav_layout" class="form-control select2bs4">
                        <option value="layout-navbar-fixed" {{ old('nav_layout', auth()->user()->nav_layout) == 'layout-navbar-fixed' ? 'selected' : '' }}>Fixed Nav Bar</option>
                        <option value="" {{ old('nav_layout', auth()->user()->nav_layout) == '' ? 'selected' : '' }}>Non Fixed Nav Bar</option>
                      </select>
                      <span class="text-danger">@error('nav_layout'){{ $message }}@enderror</span>
                    </div>
                  </div>

                  <!-- Footer Layout -->
                  <div class="col-md-6">
                    <div class="form-group">
                      <label>Footer Layout</label>
                      <select name="footer_layout" class="form-control select2bs4">
                        <option value="layout-footer-fixed" {{ old('footer_layout', auth()->user()->footer_layout) == 'layout-footer-fixed' ? 'selected' : '' }}>Fixed Fotter</option>
                        <option value="" {{ old('footer_layout', auth()->user()->footer_layout) == '' ? 'selected' : '' }}>Non Fixed Footer</option>
                      </select>
                      <span class="text-danger">@error('footer_layout'){{ $message }}@enderror</span>
                    </div>
                  </div>

                </div><!-- row -->

              </div><!-- card-body -->

              <!-- Card footer -->
              <div class="card-footer">
                @can('site.settings.update')
                @auth
                <input type="submit" class="btn bg-{{ auth()->user()->sidebar_color }}" value="Update">
                <a href="{{ route('dashboard') }}" class="btn {{ auth()->user()->sidebar_color == 'yellow' ? 'btn-dark' : 'btn-warning'}}">Cancel</a>
                @endauth
               @endcan
               @can('site.settings.restore.default')
               <a href="{{ route('site.settings.restore.default') }}" class="btn btn-danger">Restore Default Setting</a>
               @endcan

              </div>
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

