<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Auth;

class SiteSettingController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            'auth',
            new Middleware('role_or_permission:site.setting.index|
                                               site.setting.update|
                                               site.settings.restore.default'),
        ];
    }

    public function index(){

        return view('admin.setting.site.index');
    }

    public function update(Request $request)
    {
        // Validate the input data
        $validatedData = $request->validate([
            'dark_mode' => 'required|in:0,1',
            'sidebar_theam' => 'required|in:dark,light',
            'sidebar_color' => 'required|string',
            'sidebar_layout' => 'required|string',
            'nav_color' => 'required|string',
            'nav_layout' => 'string|nullable',
            'footer_layout' => 'string|nullable',
        ]);

        $user = Auth::user();
        $user->dark_mode = $validatedData['dark_mode'];
        $user->sidebar_theam = $validatedData['sidebar_theam'];
        $user->sidebar_color = $validatedData['sidebar_color'];
        $user->sidebar_layout = $validatedData['sidebar_layout'];
        $user->nav_color = $validatedData['nav_color'];
        $user->nav_layout = $validatedData['nav_layout'];
        $user->footer_layout = $validatedData['footer_layout'];
        $user->save();

        $notification = array(
            'message' => 'Site Settings Updated Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('dashboard')->with($notification);
    }

    public function restoreDefault()
    {
        $user = Auth::user();
        $user->dark_mode = 0;
        $user->sidebar_theam = 'dark';
        $user->sidebar_color = 'primary';
        $user->sidebar_layout = 'layout-fixed';
        $user->nav_color = 'navbar-white';
        $user->nav_layout = '';
        $user->footer_layout = '';
        $user->save();

        $notification = array(
            'message' => 'Site Default Settings Restored Successfully',
            'alert-type' => 'success'
        );
        return redirect()->route('dashboard')->with($notification);
    }
}
