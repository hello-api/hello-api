<?php

namespace App\Ship\Parents\Tests;

use Apiato\Abstract\Tests\TestCase as AbstractTestCase;
use App\Ship\Enums\AuthGuard;
use Illuminate\Support\Facades\Artisan;

abstract class TestCase extends AbstractTestCase
{
    public static function authGuardDataProvider(): array
    {
        return array_map(static fn (AuthGuard $guard) => [$guard->value], AuthGuard::cases());
    }

    protected function afterRefreshingDatabase(): void
    {
        $provider = array_key_exists('users', config('auth.providers')) ? 'users' : null;

        Artisan::call('passport:client', ['--personal' => true, '--name' => config('app.name') . ' Personal Access Client']);
        Artisan::call('passport:client', ['--password' => true, '--name' => config('app.name') . ' Password Grant Client', '--provider' => $provider]);
    }
}
