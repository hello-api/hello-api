<?php

namespace App\Containers\AppSection\Authentication\Tests\Functional\API;

use App\Containers\AppSection\Authentication\Tests\Functional\ApiTestCase;
use App\Containers\AppSection\Authentication\UI\API\Controllers\LoginProxyForWebClientController;
use App\Containers\AppSection\Authentication\UI\API\Controllers\RefreshProxyForWebClientController;
use App\Containers\AppSection\User\Models\User;
use Illuminate\Testing\Fluent\AssertableJson;
use PHPUnit\Framework\Attributes\CoversNothing;

#[CoversNothing]
final class RefreshProxyForWebClientTest extends ApiTestCase
{
    public function testProxyRefresh(): void
    {
        $data = [
            'email' => 'gandalf@the.grey',
            'password' => 'youShallNotPass',
        ];
        $this->actingAs(User::factory()->createOne($data), 'web');

        $loginResponse = $this->postJson(action(LoginProxyForWebClientController::class), $data);
        $response = $this->postJson(action(RefreshProxyForWebClientController::class), [
            'refresh_token' => $loginResponse['data']['refresh_token'],
        ]);

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

    public function testGivenRefreshTokenPassedAsParameterItShouldBeString(): void
    {
        $data = [
            'refresh_token' => '',
        ];

        $response = $this->postJson(action(RefreshProxyForWebClientController::class), $data);

        $response->assertUnprocessable();
        $response->assertJson(
            static fn (AssertableJson $json): AssertableJson => $json->has('errors')
                ->where('errors.refresh_token.0', 'The refresh token field must be a string.')
                ->etc(),
        );
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->setupPasswordGrantClient();
    }
}
