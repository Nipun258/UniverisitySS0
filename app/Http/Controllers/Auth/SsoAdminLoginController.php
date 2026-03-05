<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\App;

class SsoAdminLoginController extends Controller
{
    /**
     * Show the SSO Admin login page.
     */
    public function create()
    {
        return view('auth.sso_admin_login');
    }

    /**
     * Handle SSO Admin login attempt.
     */
    public function store(Request $request)
    {
        $credentials = $request->validate([
            'email'    => 'required|email',
            'password' => 'required|string',
        ]);

        if (! Auth::attempt($credentials, $request->boolean('remember'))) {
            return back()->withErrors([
                'email' => 'These credentials do not match our records.',
            ])->onlyInput('email');
        }

        $user = Auth::user();

        // Check the special SSO admin flag
        if (! $user->is_sso_admin) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return back()->withErrors([
                'email' => 'You are not authorised to access the SSO Admin Portal.',
            ])->onlyInput('email');
        }

        $request->session()->regenerate();

        // Update last login info
        if (App::environment('local')) {
            $user->update([
                'last_login_at' => Carbon::now()->toDateTimeString(),
                'last_login_ip' => $request->getClientIp(),
            ]);
        } else {
            $user->update([
                'last_login_at' => Carbon::now()->toDateTimeString(),
                'last_login_ip' => trim(shell_exec("dig +short myip.opendns.com @resolver1.opendns.com")),
            ]);
        }

        return redirect()->route('dashboard');
    }

    /**
     * Log out from SSO Admin session.
     */
    public function destroy(Request $request)
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('sso.admin.login');
    }
}
