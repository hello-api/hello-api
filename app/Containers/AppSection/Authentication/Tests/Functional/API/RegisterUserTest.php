<?php

namespace App\Containers\AppSection\Authentication\Tests\Functional\API;

use App\Containers\AppSection\Authentication\Notifications\VerifyEmail;
use App\Containers\AppSection\Authentication\Notifications\Welcome;
use App\Containers\AppSection\Authentication\Tests\Functional\ApiTestCase;
use App\Containers\AppSection\User\Models\User;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Str;
use Illuminate\Testing\Fluent\AssertableJson;
use PHPUnit\Framework\Attributes\CoversNothing;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Group;

#[Group('authentication')]
#[CoversNothing]
final class RegisterUserTest extends ApiTestCase
{
    protected string $endpoint = 'post@v1/register';

    protected bool $auth = false;

    protected array $access = [
        'permissions' => null,
        'roles' => null,
    ];

    public static function emailDataProvider(): array
    {
        $email = 'ganDalf@thE.GreY';

        return [
            'sameCasing' => compact('email'),
            'differentCasingLower' => ['email' => Str::lower($email)],
            'differentCasingUpper' => ['email' => Str::upper($email)],
        ];
    }

    public function testGivenEmailVerificationEnabledRegisterNewUserWithCredentials(): void
    {
        config()->set('appSection-authentication.require_email_verification', true);
        config()->set('appSection-authentication.allowed-verify-email-urls', 'http://some.test/known/url');

        $data = [
            'email' => 'ganldalf@the.grey',
            'password' => 's3cr3tPa$$',
            'verification_url' => 'http://some.test/known/url',
        ];

        $response = $this->makeCall($data);

        $response->assertOk();
        $response->assertJson(
            static fn (AssertableJson $json): AssertableJson => $json->has('data')
                ->where('data.email', $data['email'])
                ->etc(),
        );
    }

    public function testGivenEmailVerificationDisabledRegisterNewUserWithCredentials(): void
    {
        config()->set('appSection-authentication.require_email_verification', false);
        $data = [
            'email' => 'ganldalf@the.grey',
            'password' => 's3cr3tPa$$',
        ];

        $response = $this->makeCall($data);

        $response->assertOk();
        $response->assertJson(
            static fn (AssertableJson $json): AssertableJson => $json->has('data')
                ->where('data.email', $data['email'])
                ->etc(),
        );
    }

    public function testRegisterExistingUser(): void
    {
        $userDetails = [
            'email' => 'ganldalf@the.grey',
            'password' => 'youShallNotPass',
        ];

        $this->getTestingUser($userDetails);

        $data = [
            'email' => $userDetails['email'],
            'password' => $userDetails['password'],
        ];

        $response = $this->makeCall($data);

        $response->assertUnprocessable();
        $response->assertJson(
            static fn (AssertableJson $json): AssertableJson => $json->has('errors')
                ->where('errors.email.0', 'The email has already been taken.')
                ->etc(),
        );
    }

    public function testRegisterNewUserWithoutData(): void
    {
        $data = [];

        $response = $this->makeCall($data);

        $response->assertUnprocessable();
        if (config('appSection-authentication.require_email_verification')) {
            $response->assertJson(fn (AssertableJson $json): AssertableJson => $json->has(
                'errors',
                static fn (AssertableJson $json): AssertableJson => $json
                    ->where('email.0', 'The email field is required.')
                    ->where('password.0', 'The password field is required.')
                    ->where('verification_url.0', 'The verification url field is required.'),
            )->etc());
        } else {
            $response->assertJson(fn (AssertableJson $json): AssertableJson => $json->has(
                'errors',
                static fn (AssertableJson $json): AssertableJson => $json
                    ->where('email.0', 'The email field is required.')
                    ->where('password.0', 'The password field is required.'),
            )->etc());
        }
    }

    public function testRegisterNewUserWithInvalidEmail(): void
    {
        $data = [
            'email' => 'missing-at.test',
        ];

        $response = $this->makeCall($data);

        $response->assertUnprocessable();
        $response->assertJson(
            static fn (AssertableJson $json): AssertableJson => $json->has('errors')
                ->where('errors.email.0', 'The email field must be a valid email address.')
                ->etc(),
        );
    }

    public function testRegisterNewUserWithInvalidPassword(): void
    {
        $data = [
            'password' => '((((()))))',
        ];

        $response = $this->makeCall($data);

        $response->assertUnprocessable();
        $response->assertJson(
            static fn (AssertableJson $json): AssertableJson => $json->has('errors')
                ->has(
                    'errors.password',
                    static fn (AssertableJson $json): AssertableJson => $json
                        ->where('0', 'The password field must contain at least one uppercase and one lowercase letter.')
                        ->where('1', 'The password field must contain at least one letter.')
                        ->where('2', 'The password field must contain at least one number.'),
                )
                ->etc(),
        );
    }

    public function testRegisterNewUserWithNotAllowedVerificationUrl(): void
    {
        config()->set('appSection-authentication.require_email_verification', true);

        $data = [
            'email' => 'ganldalf@the.grey',
            'password' => 's3cr3tPa$$',
            'verification_url' => 'http://notallowed.test/wrong/hopyfuly/noone/make/a/route/like/this',
        ];

        $response = $this->makeCall($data);

        $response->assertUnprocessable();
        $response->assertJson(
            static fn (AssertableJson $json): AssertableJson => $json->has(
                'errors',
                static fn (AssertableJson $json): AssertableJson => $json->where('verification_url.0', 'The selected verification url is invalid.'),
            )->etc(),
        );
    }

    public function testGivenEmailVerificationDisabledShouldNotSendVerificationEmail(): void
    {
        config()->set('appSection-authentication.require_email_verification', false);

        Notification::fake();
        $data = [
            'email' => 'ganldalf@the.grey',
            'password' => 's3cr3tPa$$',
            'verification_url' => config('appSection-authentication.allowed-verify-email-urls')[0],
        ];

        $response = $this->makeCall($data);
        $registeredUser = User::find($this->decode($response->json()['data']['id']));
        $response->assertOk();
        Notification::assertSentTo($registeredUser, Welcome::class);
        Notification::assertNotSentTo($registeredUser, VerifyEmail::class);
    }

    #[DataProvider('emailDataProvider')]
    public function testCannotRegisterWithDuplicateEmail($email): void
    {
        $this->getTestingUser(['email' => 'ganDalf@thE.GreY']);
        $data = [
            'email' => $email,
            'password' => 's3cr3tPa$$',
            'verification_url' => config('appSection-authentication.allowed-verify-email-urls')[0],
        ];

        $response = $this->makeCall($data);

        $response->assertUnprocessable();
        $response->assertJson(
            static fn (AssertableJson $json): AssertableJson => $json->has('errors')
                ->where('errors.email.0', 'The email has already been taken.')
                ->etc(),
        );
    }
}
