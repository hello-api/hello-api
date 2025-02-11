<?php

namespace App\Containers\AppSection\Authentication\Tests\Functional\API;

use App\Containers\AppSection\Authentication\Notifications\VerifyEmail;
use App\Containers\AppSection\Authentication\Tests\Functional\ApiTestCase;
use App\Containers\AppSection\Authentication\UI\API\Controllers\SendVerificationEmailController;
use App\Containers\AppSection\User\Models\User;
use Illuminate\Support\Facades\Notification;
use Illuminate\Testing\Fluent\AssertableJson;
use PHPUnit\Framework\Attributes\CoversNothing;

#[CoversNothing]
final class SendVerificationEmailTest extends ApiTestCase
{
    public function testGivenEmailVerificationEnabledSendVerificationEmail(): void
    {
        Notification::fake();
        config()->set('appSection-authentication.require_email_verification', true);
        $user = User::factory()->unverified()->createOne();
        $this->actingAs($user);
        $data = [
            'verification_url' => config('appSection-authentication.allowed-verify-email-urls')[0],
        ];

        $response = $this->postJson(action(SendVerificationEmailController::class), $data);

        $response->assertAccepted();
        Notification::assertSentTo($user, VerifyEmail::class);
    }

    public function testSendingWithoutRequiredDataShouldThrowError(): void
    {
        config()->set('appSection-authentication.require_email_verification', true);
        $user = User::factory()->unverified()->createOne();
        $this->actingAs($user);
        $data = [];

        $response = $this->postJson(action(SendVerificationEmailController::class), $data);

        $response->assertUnprocessable();
        $response->assertJson(
            static fn (AssertableJson $json): AssertableJson => $json->has(
                'errors',
                static fn (AssertableJson $json): AssertableJson => $json->where('verification_url.0', 'The verification url field is required.'),
            )->etc(),
        );
    }

    public function testPreventSendingEmailWithNotAllowedVerificationUrl(): void
    {
        config()->set('appSection-authentication.require_email_verification', true);
        $user = User::factory()->unverified()->createOne();
        $this->actingAs($user);
        $data = [
            'verification_url' => 'http://notallowed.test/wrong',
        ];

        $response = $this->postJson(action(SendVerificationEmailController::class), $data);

        $response->assertUnprocessable();
        $response->assertJson(
            static fn (AssertableJson $json): AssertableJson => $json->has(
                'errors',
                static fn (AssertableJson $json): AssertableJson => $json->where('verification_url.0', 'The selected verification url is invalid.'),
            )->etc(),
        );
    }
}
