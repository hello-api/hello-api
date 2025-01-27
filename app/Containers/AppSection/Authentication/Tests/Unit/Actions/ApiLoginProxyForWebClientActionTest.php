<?php

namespace App\Containers\AppSection\Authentication\Tests\Unit\Actions;

use App\Containers\AppSection\Authentication\Actions\ApiLoginProxyForWebClientAction;
use App\Containers\AppSection\Authentication\Exceptions\LoginFailed;
use App\Containers\AppSection\Authentication\Tasks\CallOAuthServerTask;
use App\Containers\AppSection\Authentication\Tests\UnitTestCase;
use App\Containers\AppSection\Authentication\UI\API\Requests\LoginProxyPasswordGrantRequest;
use App\Containers\AppSection\Authentication\Values\Token;
use PHPUnit\Framework\Attributes\CoversClass;

#[CoversClass(ApiLoginProxyForWebClientAction::class)]
final class ApiLoginProxyForWebClientActionTest extends UnitTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->setupPasswordGrantClient();
    }

    public function testCanLogin(): void
    {
        $credentials = [
            'email' => 'ganldalf@the.grey',
            'password' => 'youShallNotPass',
        ];
        $this->getTestingUser($credentials);
        $this->actingAs($this->testingUser, 'web');
        $request = LoginProxyPasswordGrantRequest::injectData($credentials);
        $action = app(ApiLoginProxyForWebClientAction::class);

        $response = $action->run($request);

        $this->assertSame('refreshToken', $response->refreshTokenCookie->getName());
    }

    public function testCanLoginWithMultipleCorrectLoginFields(): void
    {
        config()->set('appSection-authentication.login.fields', ['email' => [], 'name' => []]);
        $credentials = [
            'email' => 'ganldalf@the.grey', // correct email
            'name' => 'gandalf', // correct name
            'password' => 'youShallNotPass',
        ];
        $this->getTestingUser($credentials);
        $this->actingAs($this->testingUser, 'web');
        $request = LoginProxyPasswordGrantRequest::injectData($credentials);
        $oAuthTaskMock = $this->mock(CallOAuthServerTask::class);
        $oAuthTaskMock->expects('run')->once()->andReturn(Token::fake());
        $action = app(ApiLoginProxyForWebClientAction::class, ['callOAuthServerTask' => $oAuthTaskMock]);

        $response = $action->run($request);

        $this->assertSame('refreshToken', $response->refreshTokenCookie->getName());
    }

    public function testCannotLoginWithMultipleWrongLoginFields(): void
    {
        $this->expectException(LoginFailed::class);

        config()->set('appSection-authentication.login.fields', ['email' => [], 'name' => []]);
        $userDetails = [
            'email' => 'ganldalf@the.grey',
            'name' => 'gandalf',
            'password' => 'youShallNotPass',
        ];
        $this->getTestingUser($userDetails);
        $this->actingAs($this->testingUser, 'web');
        $credentials = [
            'email' => 'ganldalf@the.white', // wrong email
            'name' => 'saruman', // wrong name
            'password' => 'youShallNotPass',
        ];
        $request = LoginProxyPasswordGrantRequest::injectData($credentials);
        $action = app(ApiLoginProxyForWebClientAction::class);

        $action->run($request);
    }

    public function testShouldStopCallingOAuthServerAfterFirstSuccessfulLogin(): void
    {
        config()->set('appSection-authentication.login.fields', ['email' => [], 'name' => []]);
        $userDetails = [
            'email' => 'ganldalf@the.grey',
            'name' => 'gandalf',
            'password' => 'youShallNotPass',
        ];
        $this->getTestingUser($userDetails);
        $this->actingAs($this->testingUser, 'web');
        $credentials = [
            'email' => 'ganldalf@the.grey', // correct email
            'name' => 'saruman', // wrong name
            'password' => 'youShallNotPass',
        ];
        $request = LoginProxyPasswordGrantRequest::injectData($credentials);
        $oAuthTaskMock = $this->mock(CallOAuthServerTask::class);
        // oauth server should be called only once
        // because the first login field is correct
        $oAuthTaskMock->expects('run')->once()->andReturn(Token::fake());
        $action = app(ApiLoginProxyForWebClientAction::class, ['callOAuthServerTask' => $oAuthTaskMock]);

        $response = $action->run($request);

        $this->assertSame('refreshToken', $response->refreshTokenCookie->getName());
    }

    public function testCanLoginWithMultipleLoginFieldsEvenIfOneFieldIsCorrect(): void
    {
        config()->set('appSection-authentication.login.fields', ['email' => [], 'name' => []]);
        $userDetails = [
            'email' => 'ganldalf@the.grey',
            'name' => 'gandalf',
            'password' => 'youShallNotPass',
        ];
        $this->getTestingUser($userDetails);
        $this->actingAs($this->testingUser, 'web');
        $credentials = [
            'email' => 'ganldalf@the.white', // wrong email
            'name' => 'gandalf', // correct name
            'password' => 'youShallNotPass',
        ];
        $request = LoginProxyPasswordGrantRequest::injectData($credentials);
        $oAuthTaskMock = $this->mock(CallOAuthServerTask::class);
        // call oauth server until it returns a token (successful login)
        // oauth server should be called twice, because the second login field is correct
        $oAuthTaskMock->expects('run')
            ->twice()
            ->andReturnUsing(
                static fn () => throw LoginFailed::create(),
                static fn () => Token::fake(),
            );
        $action = app(ApiLoginProxyForWebClientAction::class, ['callOAuthServerTask' => $oAuthTaskMock]);

        $response = $action->run($request);

        $this->assertSame('refreshToken', $response->refreshTokenCookie->getName());
    }
}
