<?php

namespace Tests\Unit\Configs;

use App\Ship\Tests\ShipTestCase;
use PHPUnit\Framework\Attributes\CoversNothing;

#[CoversNothing]
final class FileSystemsTest extends ShipTestCase
{
    public function testConfigHasCorrectValues(): void
    {
        $config = config('filesystems');
        $expected = [
            'default' => env('FILESYSTEM_DISK', 'local'),
            'disks' => [
                'local' => [
                    'driver' => 'local',
                    'root' => storage_path('app/private'),
                    'serve' => true,
                    'throw' => false,
                ],
                'public' => [
                    'driver' => 'local',
                    'root' => storage_path('app/public'),
                    'url' => env('APP_URL') . '/storage',
                    'visibility' => 'public',
                    'throw' => false,
                ],
                's3' => [
                    'driver' => 's3',
                    'key' => env('AWS_ACCESS_KEY_ID'),
                    'secret' => env('AWS_SECRET_ACCESS_KEY'),
                    'region' => env('AWS_DEFAULT_REGION'),
                    'bucket' => env('AWS_BUCKET'),
                    'url' => env('AWS_URL'),
                    'endpoint' => env('AWS_ENDPOINT'),
                    'use_path_style_endpoint' => env('AWS_USE_PATH_STYLE_ENDPOINT', false),
                    'throw' => false,
                ],
            ],
            'links' => [
                public_path('storage') => storage_path('app/public'),
            ],
        ];

        $this->assertEqualsCanonicalizing($expected, $config);
    }
}
