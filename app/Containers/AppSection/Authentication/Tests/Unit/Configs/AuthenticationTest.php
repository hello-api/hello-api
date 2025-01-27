<?php

namespace App\Containers\AppSection\Authentication\Tests\Unit\Configs;

use App\Containers\AppSection\Authentication\Tests\UnitTestCase;
use PHPUnit\Framework\Attributes\CoversNothing;

#[CoversNothing]
final class AuthenticationTest extends UnitTestCase
{
    public function testConfigHasCorrectValues(): void
    {
        $config = config('appSection-authentication');
        $expected = [
            'require_email_verification' => env('REQUIRE_EMAIL_VERIFICATION', true),
            'email_verification_link_expiration_time_in_minute' => env('EMAIL_VERIFICATION_LINK_EXPIRATION_TIME_IN_MINUTE', 30),
            'clients' => [
                'web' => [
                    'id' => env('CLIENT_WEB_ID'),
                    'secret' => env('CLIENT_WEB_SECRET'),
                ],
                'mobile' => [
                    'id' => env('CLIENT_MOBILE_ID'),
                    'secret' => env('CLIENT_MOBILE_SECRET'),
                ],
            ],
            'login' => [
                'fields' => [
                    'email' => ['email'],
                ],
                'prefix' => '',
            ],
            'allowed-reset-password-urls' => [
                env('APP_URL', 'http://api.apiato.test/v1') . '/password/reset',
            ],
            'allowed-verify-email-urls' => [
                env('APP_URL', 'http://api.apiato.test/v1') . '/email/verify',
            ],
        ];

        $this->assertEquals($expected, $config);
    }
}
