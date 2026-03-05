<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class AdminController extends Controller implements HasMiddleware
{


    public static function middleware(): array
    {
        return [
            'auth',
            new Middleware('role_or_permission:dashbord.view|perofile.view'),
        ];
    }

    public function index(){

       return view('admin.index');

    }

    public function ProfileView()
    {
        $id = Auth::user()->id;
        $user = User::find($id);
        $roles = Role::all();
        return view('admin.profile', compact('user', 'roles'));
    }


}
