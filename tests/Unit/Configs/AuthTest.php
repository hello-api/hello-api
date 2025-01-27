<?php

namespace Tests\Unit\Configs;

use App\Containers\AppSection\User\Models\User;
use App\Ship\Tests\ShipTestCase;
use PHPUnit\Framework\Attributes\CoversNothing;

#[CoversNothing]
final class AuthTest extends ShipTestCase
{
    public function testConfigHasCorrectValues(): void
    {
        $config = config('auth');
        $expected = [
            'defaults' => [
                'guard' => env('AUTH_GUARD', 'api'),
                'passwords' => env('AUTH_PASSWORD_BROKER', 'users'),
            ],
            'guards' => [
                'web' => [
                    'driver' => 'session',
                    'provider' => 'users',
                ],

                'api' => [
                    'driver' => 'passport',
                    'provider' => 'users',
                    'hash' => false,
                ],
            ],
            'providers' => [
                'users' => [
                    'driver' => 'eloquent',
                    'model' => env('AUTH_MODEL', User::class),
                ],
            ],
            'passwords' => [
                'users' => [
                    'provider' => 'users',
                    'table' => env('AUTH_PASSWORD_RESET_TOKEN_TABLE', 'password_reset_tokens'),
                    'expire' => 60,
                    'throttle' => 60,
                ],
            ],
            'password_timeout' => env('AUTH_PASSWORD_TIMEOUT', 10800),
        ];

        $this->assertEqualsCanonicalizing($expected, $config);
    }
}
