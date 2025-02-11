<?php

namespace Tests\Unit\Configs;

use App\Ship\Tests\ShipTestCase;
use Monolog\Handler\NullHandler;
use Monolog\Handler\StreamHandler;
use Monolog\Handler\SyslogUdpHandler;
use Monolog\Processor\PsrLogMessageProcessor;
use PHPUnit\Framework\Attributes\CoversNothing;

#[CoversNothing]
final class LoggingTest extends ShipTestCase
{
    public function testConfigHasCorrectValues(): void
    {
        $config = config('logging');
        $expected = [
            'default' => env('LOG_CHANNEL', 'stack'),
            'deprecations' => [
                'channel' => env('LOG_DEPRECATIONS_CHANNEL', 'null'),
                'trace' => env('LOG_DEPRECATIONS_TRACE', false),
            ],
            'channels' => [
                'stack' => [
                    'driver' => 'stack',
                    'channels' => explode(',', env('LOG_STACK', 'single')),
                    'ignore_exceptions' => false,
                ],
                'single' => [
                    'driver' => 'single',
                    'path' => storage_path('logs/laravel.log'),
                    'level' => env('LOG_LEVEL', 'debug'),
                    'replace_placeholders' => true,
                ],
                'daily' => [
                    'driver' => 'daily',
                    'path' => storage_path('logs/laravel.log'),
                    'level' => env('LOG_LEVEL', 'debug'),
                    'days' => env('LOG_DAILY_DAYS', 14),
                    'replace_placeholders' => true,
                ],
                'slack' => [
                    'driver' => 'slack',
                    'url' => env('LOG_SLACK_WEBHOOK_URL'),
                    'username' => env('LOG_SLACK_USERNAME', 'Laravel Log'),
                    'emoji' => env('LOG_SLACK_EMOJI', ':boom:'),
                    'level' => env('LOG_LEVEL', 'critical'),
                    'replace_placeholders' => true,
                ],
                'papertrail' => [
                    'driver' => 'monolog',
                    'level' => env('LOG_LEVEL', 'debug'),
                    'handler' => env('LOG_PAPERTRAIL_HANDLER', SyslogUdpHandler::class),
                    'handler_with' => [
                        'host' => env('PAPERTRAIL_URL'),
                        'port' => env('PAPERTRAIL_PORT'),
                        'connectionString' => 'tls://' . env('PAPERTRAIL_URL') . ':' . env('PAPERTRAIL_PORT'),
                    ],
                    'processors' => [PsrLogMessageProcessor::class],
                ],
                'stderr' => [
                    'driver' => 'monolog',
                    'level' => env('LOG_LEVEL', 'debug'),
                    'handler' => StreamHandler::class,
                    'formatter' => env('LOG_STDERR_FORMATTER'),
                    'with' => [
                        'stream' => 'php://stderr',
                    ],
                    'processors' => [PsrLogMessageProcessor::class],
                ],
                'syslog' => [
                    'driver' => 'syslog',
                    'level' => env('LOG_LEVEL', 'debug'),
                    'facility' => env('LOG_SYSLOG_FACILITY', LOG_USER),
                    'replace_placeholders' => true,
                ],
                'errorlog' => [
                    'driver' => 'errorlog',
                    'level' => env('LOG_LEVEL', 'debug'),
                    'replace_placeholders' => true,
                ],
                'null' => [
                    'driver' => 'monolog',
                    'handler' => NullHandler::class,
                ],
                'emergency' => [
                    'path' => storage_path('logs/laravel.log'),
                ],
            ],
        ];

        $this->assertEqualsCanonicalizing($expected, $config);
    }
}
