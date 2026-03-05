<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.admin_login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        if (App::environment('local')) {

            $request->user()->update([
                'last_login_at' => Carbon::now()->toDateTimeString(),
                'last_login_ip' => $request->getClientIp(),
            ]);

        } else {

            $request->user()->update([
                'last_login_at' => Carbon::now()->toDateTimeString(),
                'last_login_ip' => trim(shell_exec("dig +short myip.opendns.com @resolver1.opendns.com")),
            ]);

        }

        // 1. OAuth authorization flow → return to Passport to complete the handshake
        $intended = session()->pull('url.intended', null);
        if ($intended && str_contains($intended, '/oauth/authorize')) {
            return redirect($intended);
        }

        // 2. Direct login → initiate the OAuth flow for the Master Client.
        //    Because the user is now authenticated in the SSO session, Passport
        //    will auto-complete the handshake and land them in the client app
        //    fully authenticated — without needing a second login.
        $clientId    = config('sso.master_client_id');
        $redirectUri = config('sso.master_client_redirect');

        if ($clientId && $redirectUri) {
            $query = http_build_query([
                'client_id'     => $clientId,
                'redirect_uri'  => $redirectUri,
                'response_type' => 'code',
                'scope'         => '',
            ]);
            return redirect('/oauth/authorize?' . $query);
        }

        // Fallback if master client is not configured
        return redirect('/login');
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
