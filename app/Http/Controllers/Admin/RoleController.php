<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class RoleController extends Controller implements HasMiddleware
{

    public static function middleware(): array
    {
        return [
            'auth',
            new Middleware('role_or_permission:role.index|
                            role.create|
                            role.updation|
                            role.delete|
                            role.permission.list|
                            role.permission.update|
                            role.permissions.revoke|
                            role.permissions.sync'),
        ];
    }

    public function roleIndex()
    {

        $roles =  Role::all();
        return view('admin.role.index', compact('roles'));

    }

    public function roleAdd()
    {

        return view('admin.role.add');

    }

    public function roleStore(Request $request)
    {

        $validatedData = $request->validate([
            'name' => 'required|unique:roles,name|min:3',
        ], [
            'name.required' => 'Enter Valid Role Name',
            'name.min' => 'Name Should be minimum 3 character'
        ]);

        $data = new Role();
        $data->name = $request->name;
        $data->save();

        $notification = array(
            'message' => 'New Role Inserted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('role.index')->with($notification);
    }

    public function roleEdit($id)
    {

        $role = Role::find($id);
        $premissions = Permission::all();
        return view('admin.role.edit', compact('role','premissions'));

    }

    public function roleUpdate(Request $request, $id)
    {

        $validatedData = $request->validate([
            'name' => 'required|min:3',
        ], [
            'name.required' => 'Enter Valid Role Name',
            'name.min' => 'Name Should be minimum 3 character'
        ]);


        $data = Role::find($id);
        $data->name = $request->name;
        $data->save();

        $notification = array(
            'message' => 'Role data Updated Successfully',
            'alert-type' => 'info'
        );

        return redirect()->route('role.index')->with($notification);
    }

    public function roleDelete($id)
    {

        $role = Role::find($id);
        $role->delete();

        $notification = array(
            'message' => 'Role Permenetly Deleted Successfully',
            'alert-type' => 'error'
        );

        return redirect()->route('role.index')->with($notification);

    }

    public function rolePermissionList($id){

        $role = Role::find($id);
        $permissions = Permission::join('categories', 'categories.id', '=', 'permissions.permission_group_category_id')
                      ->select('permissions.*', 'categories.category_name as category_name')->get();
        return view('admin.role.permission_assign', compact('role','permissions'));

    }


    public function permissionRoleUpdate(Request $request,Role $role)
    {
        $validatedData = $request->validate([
            'permission' => 'required',
        ], [
            'permission.required' => 'select valid permission',
        ]);

        if($role->hasPermissionTo($request->permission)){

            $notification = array(
                'message' => 'New Role Permission already Exist',
                'alert-type' => 'info'
            );
            return redirect()->route('role.edit', ['id' => $role])->with($notification);
        }

        $role->givePermissionTo($request->permission);


        $notification = array(
            'message' => 'New Role Permission Added Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('role.edit', ['id' => $role])->with($notification);
    }

    public function revokePermission(Role $role, Permission $permission)
    {
        if($role->hasPermissionTo($permission)){
            $role->revokePermissionTo($permission);

            $notification = array(
                'message' => 'Role Permission revoked',
                'alert-type' => 'error'
            );

            return redirect()->route('role.edit', ['id' => $role])->with($notification);

        }
        $notification = array(
            'message' => 'Role Permission not exists',
            'alert-type' => 'info'
        );

        return redirect()->route('role.edit', ['id' => $role])->with($notification);
    }

    public function syncPermissions(Request $request, Role $role)
{
    $request->validate([
        'permissions' => 'required|array|min:1', // Ensure at least one permission is selected
    ]);

    $permissions = $request->input('permissions', []);
    $role->syncPermissions($permissions);

    $notification = array(
        'message' => 'Permissions synced successfully!',
        'alert-type' => 'success'
    );

    return redirect()->route('role.index')->with($notification);
}

}
