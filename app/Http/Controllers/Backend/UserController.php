<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class UserController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            'auth',
            new Middleware('role_or_permission:user.view|
                                               user.create|
                                               user.updation|
                                               user.delete|
                                               user.inactivate|
                                               user.activate|
                                               user.show|
                                               user.roles.assign|
                                               user.roles.remove|
                                               user.permissions.assign|
                                               user.permissions.revoke'),
        ];
    }

    public function UserView(){

          $users = User::join('model_has_roles', 'model_has_roles.model_id', '=', 'users.id')
                ->join('roles', 'roles.id', '=', 'model_has_roles.role_id')
                ->select('users.id','users.status','users.name','users.email')
                ->groupBy('users.id','users.status','users.name','users.email')
                ->selectRaw('GROUP_CONCAT(roles.name) as roles')
                ->orderby('users.id')
                ->where('users.is_sso_admin',1)
                ->get();

    return view('admin.user.index',compact('users'));

    }

    public function UserAddView()
    {

        $roles = Role::all();

        $userDetails = Http::withHeaders([
            'Content-Type' => 'application/json',
            ])->post('https://hrms.sjp.ac.lk/api/employee/data/get');

        $empData = json_decode($userDetails, true);

        return view('admin.user.add',compact('roles','empData'));
    }

    public function UserStore(Request $request)
    {
        $validatedData = $request->validate([
            'empno' => 'required',
            'role' => 'required'
        ]);
        $selectedEmployee = explode('|', $request->input('empno'));
        $employeeNo = $selectedEmployee[0];
        $email = $selectedEmployee[1];
        $lastname = $selectedEmployee[2];
        $initials = $selectedEmployee[3];

        if (User::where('email', $email)->exists()) {

            $notification = array(
                'message' => 'User Already in the system',
                'alert-type' => 'warning'
             );

             return redirect()->route('user.view')->with($notification);

        }

        $data = new User();
        $code = rand(0000,9999);
        //$data->empNo = $employeeNo;
        $data->name =  $initials.' '.$lastname;
        $data->email = $email;
        $data->password = bcrypt($code);
        $data->status = 1;
        $data->save();

        $data->assignRole($request->role);

        $notification = array(
           'message' => 'User Inserted Successfully',
           'alert-type' => 'success'
        );

        return redirect()->route('user.view')->with($notification);
    }

    public function UserEdit($id)
    {
        $editData = User::find($id);
        return view('admin.user.edit',compact('editData'));
    }

    public function UserUpdate(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
        ]);

        $data = User::findOrFail($id);
        $data->name         = $request->name;
        $data->email        = $request->email;
        $data->status       = $request->boolean('status') ? 1 : 0;
        $data->is_sso_admin = $request->boolean('is_sso_admin') ? 1 : 0;
        $data->save();

        $notification = [
            'message'    => 'User Updated Successfully',
            'alert-type' => 'info',
        ];

        return redirect()->route('user.view')->with($notification);
    }

    public function UserDelete($id){


        $user = User::find($id);

        if ($user->hasRole('admin')) {

            $notification = array(
                'message' => 'Admin Account Can not be delete',
                'alert-type' => 'error'
             );

             return redirect()->route('user.view')->with($notification);

        }
        $user->delete();

        $notification = array(
           'message' => 'User Deleted Successfully',
           'alert-type' => 'success'
        );

        return redirect()->route('user.view')->with($notification);
    }

    public function UserInactive($id){


        $user = User::find($id);

        if ($user->hasRole('admin')) {

            $notification = array(
                'message' => 'Administrative Account Can not be deactivate',
                'alert-type' => 'error'
             );

             return redirect()->route('user.view')->with($notification);

        }
        $user->status = 0;
        $user->save();

        $notification = array(
            'message' => 'User deactive successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);


     }//end method


      public function UserActive($id){

        $user = User::find($id);
        $user->status = 1;
        $user->save();

        $notification = array(
            'message' => 'User Active successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);


    }//end method

    public function UserShow($id)
    {
        $user = User::find($id);
        $roles = Role::all();
        $permissions = Permission::all();

        return view('admin.user.show', compact('user', 'roles', 'permissions'));
    }

    public function assignRole(Request $request, User $user)
    {
        $validatedData = $request->validate([
            'role' => 'required',
        ], [
            'role.required' => 'select valid role',
        ]);

        if ($user->hasRole($request->role)) {

            $notification = array(
                'message' => 'Role already add to the user',
                'alert-type' => 'info'
            );
            return redirect()->route('user.show', ['id' => $user])->with($notification);
        }

        $user->assignRole($request->role);

        $notification = array(
            'message' => 'Role added to the user',
            'alert-type' => 'success'
        );
        return redirect()->route('user.show', ['id' => $user])->with($notification);
    }

    public function removeRole(User $user, Role $role)
    {


        if ($user->hasRole($role)) {
            $user->removeRole($role);
            $notification = array(
                'message' => 'Role removed from the user',
                'alert-type' => 'error'
            );
            return redirect()->route('user.show', ['id' => $user])->with($notification);
        }

        $notification = array(
            'message' => 'Role not exsits',
            'alert-type' => 'error'
        );
        return redirect()->route('user.show', ['id' => $user])->with($notification);
    }

    public function givePermission(Request $request, User $user)
    {
        $validatedData = $request->validate([
            'permission' => 'required',
        ], [
            'permission.required' => 'select valid permission',
        ]);

        if ($user->hasPermissionTo($request->permission)) {

            $notification = array(
                'message' => 'Permission already add to the user',
                'alert-type' => 'info'
            );
            return redirect()->route('user.show', ['id' => $user])->with($notification);
        }
        $user->givePermissionTo($request->permission);

        $notification = array(
            'message' => 'Permission added to the user',
            'alert-type' => 'success'
        );
        return redirect()->route('user.show', ['id' => $user])->with($notification);
    }

    public function revokePermission(User $user, Permission $permission)
    {
        if ($user->hasPermissionTo($permission)) {
            $user->revokePermissionTo($permission);
            $notification = array(
                'message' => 'Permission revoked to the user',
                'alert-type' => 'warning'
            );
            return redirect()->route('user.show', ['id' => $user])->with($notification);
        }

        $notification = array(
            'message' => 'Permission dose not exsits',
            'alert-type' => 'info'
        );
        return redirect()->route('user.show', ['id' => $user])->with($notification);
    }



}
