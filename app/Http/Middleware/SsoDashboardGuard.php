<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SsoDashboardGuard
{
    /**
     * Block access to the SSO dashboard for users without is_sso_admin = true.
     * Redirects them to the configured master client application URL.
     */
    public function handle(Request $request, Closure $next)
    {
        if (! auth()->check() || ! auth()->user()->is_sso_admin) {
            return redirect(config('sso.master_client_url'));
        }

        return $next($request);
    }
}
