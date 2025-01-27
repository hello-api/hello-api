<?php

namespace Tests\Unit\Configs;

use App\Ship\Tests\ShipTestCase;
use Illuminate\Support\Str;
use PHPUnit\Framework\Attributes\CoversNothing;

#[CoversNothing]
final class SessionTest extends ShipTestCase
{
    public function testConfigHasCorrectValues(): void
    {
        $config = config('session');
        $expected = [
            'driver' => env('SESSION_DRIVER', 'database'),
            'lifetime' => env('SESSION_LIFETIME', 120),
            'expire_on_close' => env('SESSION_EXPIRE_ON_CLOSE', false),
            'encrypt' => env('SESSION_ENCRYPT', false),
            'files' => storage_path('framework/sessions'),
            'connection' => env('SESSION_CONNECTION'),
            'table' => env('SESSION_TABLE', 'sessions'),
            'store' => env('SESSION_STORE'),
            'lottery' => [2, 100],
            'cookie' => env(
                'SESSION_COOKIE',
                Str::slug(env('APP_NAME', 'laravel'), '_').'_session'
            ),
            'path' => env('SESSION_PATH', '/'),
            'domain' => env('SESSION_DOMAIN'),
            'secure' => env('SESSION_SECURE_COOKIE'),
            'http_only' => env('SESSION_HTTP_ONLY', true),
            'same_site' => env('SESSION_SAME_SITE', 'lax'),
            'partitioned' => env('SESSION_PARTITIONED_COOKIE', false),
        ];

        $this->assertEqualsCanonicalizing($expected, $config);
    }
}
