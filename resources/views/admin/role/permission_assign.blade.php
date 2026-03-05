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
                            <h3 class="card-title"><a href="{{ route('role.index') }}"><i class="fa fa-arrow-circle-left" aria-hidden="true"
                                        style="font-size: 30px;"></i></a> Permission Assign to Role</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->

                        <div class="card-body">

                            <form method="post" action="{{ route('role.syncPermissions', $role->id) }}">
                                @csrf
                                <div class="col-md-12">
                                    <div class="col-md-12 text-center">
                                        <input type="checkbox" name="permission1" id="all" class="form-check-input"
                                            onclick=" for(c in document.getElementsByName('permissions[]')) document.getElementsByName('permissions[]').item(c).checked = this.checked" />
                                        <label for="all">Select All Permissions</label><br>
                                        <span class="text-danger">
                                            @error('permission1')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>

                                    @foreach ($permissions->groupBy('permission_group_category_id') as $categoryId => $groupedPermissions)
                                        <!-- Card for each category -->
                                        <div class="card mb-3 ml-3">
                                            <div class="card-header bg-slate-500">
                                                {{ ucfirst($groupedPermissions->first()->category_name) ?? 'Unknown Category' }}
                                            </div>
                                            <div class="card-body">
                                                <div class="row">
                                                    @foreach ($groupedPermissions as $key => $permission)
                                                        <div class="col-md-4">
                                                            <!-- Permission Checkbox -->
                                                            <div class="form-group">
                                                                <input type="checkbox" name="permissions[]" id="{{ $permission->id }}"
                                                                    class="form-check-input" value="{{ $permission->name }}"
                                                                    {{ $role->hasPermissionTo($permission->name) ? 'checked' : '' }} />
                                                                <label for="{{ $permission->id }}">{{ $permission->name }}</label>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach

                                </div>

                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer">
                            @auth
                            <input type="submit" class="btn bg-{{ auth()->user()->sidebar_color }}" value="Assign Permissions">
                            @endauth
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
