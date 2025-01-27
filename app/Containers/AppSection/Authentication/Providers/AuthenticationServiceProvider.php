<?php

namespace App\Containers\AppSection\Authentication\Providers;

use App\Ship\Parents\Providers\ServiceProvider as ParentServiceProvider;
use Carbon\Carbon;
use Laravel\Passport\Passport;

class AuthenticationServiceProvider extends ParentServiceProvider
{
    public function register(): void
    {
        Passport::ignoreRoutes();
    }

    public function boot(): void
    {
        if (config('apiato.api.enabled-implicit-grant')) {
            Passport::enableImplicitGrant();
        }

        Passport::enablePasswordGrant();

        Passport::tokensExpireIn(Carbon::now()->addMinutes((int) config('apiato.api.expires-in')));
        Passport::refreshTokensExpireIn(Carbon::now()->addMinutes((int) config('apiato.api.refresh-expires-in')));
    }
}
