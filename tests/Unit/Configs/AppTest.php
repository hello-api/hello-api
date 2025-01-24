<?php

namespace Tests\Unit\Configs;

use App\Ship\Tests\ShipTestCase;
use Illuminate\Auth\AuthServiceProvider;
use Illuminate\Auth\Passwords\PasswordResetServiceProvider;
use Illuminate\Broadcasting\BroadcastServiceProvider;
use Illuminate\Bus\BusServiceProvider;
use Illuminate\Cache\CacheServiceProvider;
use Illuminate\Concurrency\ConcurrencyServiceProvider;
use Illuminate\Cookie\CookieServiceProvider;
use Illuminate\Database\DatabaseServiceProvider;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Encryption\EncryptionServiceProvider;
use Illuminate\Filesystem\FilesystemServiceProvider;
use Illuminate\Foundation\Providers\ConsoleSupportServiceProvider;
use Illuminate\Foundation\Providers\FoundationServiceProvider;
use Illuminate\Hashing\HashServiceProvider;
use Illuminate\Mail\MailServiceProvider;
use Illuminate\Notifications\NotificationServiceProvider;
use Illuminate\Pagination\PaginationServiceProvider;
use Illuminate\Pipeline\PipelineServiceProvider;
use Illuminate\Queue\QueueServiceProvider;
use Illuminate\Redis\RedisServiceProvider;
use Illuminate\Session\SessionServiceProvider;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Concurrency;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Context;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Process;
use Illuminate\Support\Facades\Queue;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schedule;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Vite;
use Illuminate\Support\Js;
use Illuminate\Support\Number;
use Illuminate\Support\Str;
use Illuminate\Support\Uri;
use Illuminate\Translation\TranslationServiceProvider;
use Illuminate\Validation\ValidationServiceProvider;
use Illuminate\View\ViewServiceProvider;
use PHPUnit\Framework\Attributes\CoversNothing;
use App\Containers\AppSection\User\Providers\UserServiceProvider;
use App\Containers\AppSection\Authentication\Providers\AuthenticationServiceProvider;
use App\Ship\Providers\ShipServiceProvider;

#[CoversNothing]
final class AppTest extends ShipTestCase
{
    public function testConfigHasCorrectValues(): void
    {
        $config = config('app');
        $expected = [
            'name' => env('APP_NAME', 'Apiato'),
            'env' => env('APP_ENV', 'production'),
            'debug' => (bool) env('APP_DEBUG', false),
            'url' => env('APP_URL', 'http://localhost'),
            'frontend_url' => env('FRONTEND_URL', 'http://localhost:3000'),
            'asset_url' => env('ASSET_URL', env('ASSET_URL')),
            'timezone' => env('APP_TIMEZONE', 'UTC'),
            'locale' => env('APP_LOCALE', 'en'),
            'fallback_locale' => env('APP_FALLBACK_LOCALE', 'en'),
            'faker_locale' => env('APP_FAKER_LOCALE', 'en_US'),
            'cipher' => 'AES-256-CBC',
            'key' => env('APP_KEY'),
            'previous_keys' => array_filter(
                explode(',', env('APP_PREVIOUS_KEYS', '')),
            ),
            'maintenance' => [
                'driver' => env('APP_MAINTENANCE_DRIVER', 'file'),
                'store' => env('APP_MAINTENANCE_STORE', 'database'),
            ],
            'providers' => [
                AuthServiceProvider::class,
                BroadcastServiceProvider::class,
                BusServiceProvider::class,
                CacheServiceProvider::class,
                ConsoleSupportServiceProvider::class,
                ConcurrencyServiceProvider::class,
                CookieServiceProvider::class,
                DatabaseServiceProvider::class,
                EncryptionServiceProvider::class,
                FilesystemServiceProvider::class,
                FoundationServiceProvider::class,
                HashServiceProvider::class,
                MailServiceProvider::class,
                NotificationServiceProvider::class,
                PaginationServiceProvider::class,
                PasswordResetServiceProvider::class,
                PipelineServiceProvider::class,
                QueueServiceProvider::class,
                RedisServiceProvider::class,
                SessionServiceProvider::class,
                TranslationServiceProvider::class,
                ValidationServiceProvider::class,
                ViewServiceProvider::class,
                ShipServiceProvider::class,
                AuthenticationServiceProvider::class,
                UserServiceProvider::class,
            ],
            'aliases' => [
                'App' => App::class,
                'Arr' => Arr::class,
                'Artisan' => Artisan::class,
                'Auth' => Auth::class,
                'Blade' => Blade::class,
                'Broadcast' => Broadcast::class,
                'Bus' => Bus::class,
                'Cache' => Cache::class,
                'Concurrency' => Concurrency::class,
                'Config' => Config::class,
                'Context' => Context::class,
                'Cookie' => Cookie::class,
                'Crypt' => Crypt::class,
                'Date' => Date::class,
                'DB' => DB::class,
                'Eloquent' => Model::class,
                'Event' => Event::class,
                'File' => File::class,
                'Gate' => Gate::class,
                'Hash' => Hash::class,
                'Http' => Http::class,
                'Js' => Js::class,
                'Lang' => Lang::class,
                'Log' => Log::class,
                'Mail' => Mail::class,
                'Notification' => Notification::class,
                'Number' => Number::class,
                'Password' => Password::class,
                'Process' => Process::class,
                'Queue' => Queue::class,
                'RateLimiter' => RateLimiter::class,
                'Redirect' => Redirect::class,
                'Request' => Request::class,
                'Response' => Response::class,
                'Route' => Route::class,
                'Schedule' => Schedule::class,
                'Schema' => Schema::class,
                'Session' => Session::class,
                'Storage' => Storage::class,
                'Str' => Str::class,
                'URL' => URL::class,
                'Uri' => Uri::class,
                'Validator' => Validator::class,
                'View' => View::class,
                'Vite' => Vite::class,
            ],
        ];

        $this->assertEqualsCanonicalizing($expected, $config);
    }
}
