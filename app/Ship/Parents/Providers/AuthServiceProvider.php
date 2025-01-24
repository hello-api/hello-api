<?php

namespace App\Ship\Parents\Providers;

use Apiato\Abstract\Providers\AuthServiceProvider as AbstractAuthServiceProvider;

abstract class AuthServiceProvider extends AbstractAuthServiceProvider
{
    /**
     * The policy mappings for the application.
     */
    protected $policies = [];
}
