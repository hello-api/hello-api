<?php

namespace Tests\Unit\Configs;

use App\Ship\Tests\ShipTestCase;
use PHPUnit\Framework\Attributes\CoversNothing;

#[CoversNothing]
final class BroadcastingTest extends ShipTestCase
{
    public function testConfigHasCorrectValues(): void
    {
        $config = config('broadcasting');
        $expected = [
            'default' => env('BROADCAST_CONNECTION', 'null'),
            'connections' => [
                'reverb' => [
                    'driver' => 'reverb',
                    'key' => env('REVERB_APP_KEY'),
                    'secret' => env('REVERB_APP_SECRET'),
                    'app_id' => env('REVERB_APP_ID'),
                    'options' => [
                        'host' => env('REVERB_HOST'),
                        'port' => env('REVERB_PORT', 443),
                        'scheme' => env('REVERB_SCHEME', 'https'),
                        'useTLS' => 'https' === env('REVERB_SCHEME', 'https'),
                    ],
                    'client_options' => [],
                ],
                'pusher' => [
                    'driver' => 'pusher',
                    'key' => env('PUSHER_APP_KEY'),
                    'secret' => env('PUSHER_APP_SECRET'),
                    'app_id' => env('PUSHER_APP_ID'),
                    'options' => [
                        'cluster' => env('PUSHER_APP_CLUSTER'),
                        'host' => env('PUSHER_HOST') ?: 'api-' . env('PUSHER_APP_CLUSTER', 'mt1') . '.pusher.com',
                        'port' => env('PUSHER_PORT', 443),
                        'scheme' => env('PUSHER_SCHEME', 'https'),
                        'encrypted' => true,
                        'useTLS' => 'https' === env('PUSHER_SCHEME', 'https'),
                    ],
                    'client_options' => [],
                ],
                'ably' => [
                    'driver' => 'ably',
                    'key' => env('ABLY_KEY'),
                ],
                'log' => [
                    'driver' => 'log',
                ],
                'null' => [
                    'driver' => 'null',
                ],
            ],
        ];

        $this->assertEqualsCanonicalizing($expected, $config);
    }
}
