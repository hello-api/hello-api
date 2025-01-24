<?php

namespace App\Containers\AppSection\Authentication\Tests\Functional\API;

use App\Containers\AppSection\Authentication\Tests\Functional\ApiTestCase;
use Illuminate\Testing\Fluent\AssertableJson;
use PHPUnit\Framework\Attributes\CoversNothing;

#[CoversNothing]
final class LoginProxyForWebClientTest extends ApiTestCase
{
    protected string $endpoint = 'post@v1/clients/web/login';

    protected function setUp(): void
    {
        parent::setUp();

        $this->setupPasswordGrantClient();
    }

    public function testProxyLogin(): void
    {
        $data = [
            'email' => 'gandalf@the.grey',
            'password' => 'youShallNotPass',
        ];
        $this->getTestingUser($data);

        $response = $this->makeCall($data);

        $response->assertOk();
        $response->assertJson(
            static fn (AssertableJson $json): AssertableJson => $json->has(
                'data',
                static fn (AssertableJson $json): AssertableJson => $json->hasAll([
                    'access_token',
                    'refresh_token',
                    'token_type',
                    'expires_in',
                ])->where('token_type', 'Bearer')
                ->etc(),
            )->etc(),
        );
    }

    public function testLoginWithNameAttribute(): void
    {
        $data = [
            'email' => 'gandalf@the.grey',
            'password' => 'youShallNotPass',
            'name' => 'username',
        ];
        $this->getTestingUser($data);
        $this->setLoginAttributes([
            'email' => [],
            'name' => [],
        ]);
        $request = [
            'password' => 'youShallNotPass',
            'name' => 'username',
        ];

        $response = $this->makeCall($request);

        $response->assertOk();
    }

    private function setLoginAttributes(array $fields): void
    {
        config()->set('appSection-authentication.login.fields', $fields);
    }

    public function testGivenOnlyOneLoginAttributeIsSetThenItShouldBeRequired(): void
    {
        $this->setLoginAttributes([
            'email' => [],
        ]);
        $data = [
            'password' => 'youShallNotPass',
        ];

        $response = $this->makeCall($data);

        $response->assertUnprocessable();
        $response->assertJson(fn (AssertableJson $json): AssertableJson => $json->has(
            'errors',
            static fn (AssertableJson $json): AssertableJson => $json
                ->where('email.0', 'The email field is required.'),
        )->etc());
    }

    public function testGivenMultipleLoginAttributeIsSetThenAtLeastOneShouldBeRequired(): void
    {
        $this->setLoginAttributes([
            'email' => [],
            'name' => [],
        ]);
        $data = [
            'password' => 'youShallNotPass',
        ];

        $response = $this->makeCall($data);

        $response->assertUnprocessable();
        $response->assertJson(fn (AssertableJson $json): AssertableJson => $json->has(
            'errors',
            static fn (AssertableJson $json): AssertableJson => $json
                ->where('email.0', 'The email field is required when none of name are present.')
                ->where('name.0', 'The name field is required when none of email are present.'),
        )->etc());
    }

    public function testGivenWrongCredentialThrowException(): void
    {
        $data = [
            'email' => 'ganldalf@the.grey',
            'password' => 'youShallNotPass',
        ];

        $response = $this->makeCall($data);

        $response->assertUnprocessable();
    }
}
