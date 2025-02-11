<?php

namespace App\Containers\AppSection\Authentication\Tests\Functional\API;

use App\Containers\AppSection\Authentication\Tests\Functional\ApiTestCase;
use App\Containers\AppSection\Authentication\UI\API\Controllers\ForgotPasswordController;
use Illuminate\Testing\Fluent\AssertableJson;
use PHPUnit\Framework\Attributes\CoversNothing;

#[CoversNothing]
final class ForgotPasswordTest extends ApiTestCase
{
    public function testForgotPassword(): void
    {
        $resetUrl = 'http://somereseturl.test/yea/something';
        config()->set('appSection-authentication.allowed-reset-password-urls', $resetUrl);
        $data = [
            'email' => 'admin@admin.com',
            'reseturl' => $resetUrl,
        ];

        $response = $this->postJson(action(ForgotPasswordController::class), $data);

        $response->assertNoContent();
    }

    public function testForgotPasswordWithNotAllowedVerificationUrl(): void
    {
        config()->set('appSection-authentication.allowed-reset-password-urls', []);

        $data = [
            'email' => 'ganldalf@the.grey',
            'password' => 'youShallNotPass',
            'reseturl' => 'http://notallowed.test/wrong',
        ];

        $response = $this->postJson(action(ForgotPasswordController::class), $data);

        $response->assertUnprocessable();
        $response->assertJson(
            static fn (AssertableJson $json): AssertableJson => $json->has(
                'errors',
                static fn (AssertableJson $json): AssertableJson => $json
                    ->where('reseturl.0', 'The selected reseturl is invalid.'),
            )->etc(),
        );
    }
}
