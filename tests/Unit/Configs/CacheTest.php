<?php

namespace Tests\Unit\Configs;

use App\Ship\Tests\ShipTestCase;
use Illuminate\Support\Str;
use PHPUnit\Framework\Attributes\CoversNothing;

#[CoversNothing]
final class CacheTest extends ShipTestCase
{
    public function testConfigHasCorrectValues(): void
    {
        $config = config('cache');
        $expected = [
            'default' => env('CACHE_STORE', 'database'),
            'stores' => [
                'array' => [
                    'driver' => 'array',
                    'serialize' => false,
                ],
                'database' => [
                    'driver' => 'database',
                    'connection' => env('DB_CACHE_CONNECTION'),
                    'table' => env('DB_CACHE_TABLE', 'cache'),
                    'lock_connection' => env('DB_CACHE_LOCK_CONNECTION'),
                    'lock_table' => env('DB_CACHE_LOCK_TABLE'),
                ],
                'file' => [
                    'driver' => 'file',
                    'path' => storage_path('framework/cache/data'),
                    'lock_path' => storage_path('framework/cache/data'),
                ],
                'memcached' => [
                    'driver' => 'memcached',
                    'persistent_id' => env('MEMCACHED_PERSISTENT_ID'),
                    'sasl' => [
                        env('MEMCACHED_USERNAME'),
                        env('MEMCACHED_PASSWORD'),
                    ],
                    'options' => [],
                    'servers' => [
                        [
                            'host' => env('MEMCACHED_HOST', '127.0.0.1'),
                            'port' => env('MEMCACHED_PORT', 11211),
                            'weight' => 100,
                        ],
                    ],
                ],
                'redis' => [
                    'driver' => 'redis',
                    'connection' => env('REDIS_CACHE_CONNECTION', 'cache'),
                    'lock_connection' => env('REDIS_CACHE_LOCK_CONNECTION', 'default'),
                ],
                'dynamodb' => [
                    'driver' => 'dynamodb',
                    'key' => env('AWS_ACCESS_KEY_ID'),
                    'secret' => env('AWS_SECRET_ACCESS_KEY'),
                    'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
                    'table' => env('DYNAMODB_CACHE_TABLE', 'cache'),
                    'endpoint' => env('DYNAMODB_ENDPOINT'),
                ],
                'octane' => [
                    'driver' => 'octane',
                ],
            ],
            'prefix' => env('CACHE_PREFIX', Str::slug(env('APP_NAME', 'laravel'), '_') . '_cache_'),
        ];

        $this->assertEqualsCanonicalizing($expected, $config);
    }
}
