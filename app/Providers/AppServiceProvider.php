<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Laravel\Passport\Passport;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Gate::before(function ($user, $ability) {
            if ($user->hasRole('Super-Admin')) {
                return true;
            }
        });

        // Register Passport's OAuth authorization consent screen view.
        // Required by Passport v13 - without this the /oauth/authorize
        // endpoint throws "Target [AuthorizationViewResponse] is not instantiable".
        Passport::authorizationView('oauth.authorize');
    }
}
