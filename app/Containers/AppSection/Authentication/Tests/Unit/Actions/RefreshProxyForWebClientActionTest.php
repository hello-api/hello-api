<?php

namespace App\Containers\AppSection\Authentication\Tests\Unit\Actions;

use App\Containers\AppSection\Authentication\Actions\RefreshProxyForWebClientAction;
use App\Containers\AppSection\Authentication\Tasks\CallOAuthServerTask;
use App\Containers\AppSection\Authentication\Tests\UnitTestCase;
use App\Containers\AppSection\Authentication\UI\API\Requests\RefreshProxyRequest;
use App\Containers\AppSection\User\Models\User;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;

#[UsesClass(CallOAuthServerTask::class)]
#[CoversClass(RefreshProxyForWebClientAction::class)]
final class RefreshProxyForWebClientActionTest extends UnitTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->setupPasswordGrantClient();
    }

    public function testCanRefreshToken(): void
    {
        $data = [
            'email' => 'gandalf@the.grey',
            'password' => 'youShallNotPass',
        ];
        User::factory()->createOne($data);
        $request = RefreshProxyRequest::injectData([
            'refresh_token' => $this->createRefreshTokenFor($data['email'], $data['password']),
        ]);
        $action = app(RefreshProxyForWebClientAction::class);

        $response = $action->run($request);

        $this->assertSame('refreshToken', $response->refreshTokenCookie->getName());
    }

    private function createRefreshTokenFor(string $email, string $password): string
    {
        return app(CallOAuthServerTask::class)->run($this->enrichWithPasswordGrantFields($email, $password))->refreshToken;
    }

    public function testCanRefreshTokenFromCookie(): void
    {
        $data = [
            'email' => 'gandalf@the.grey',
            'password' => 'youShallNotPass',
        ];
        User::factory()->createOne($data);
        $request = RefreshProxyRequest::injectData(
            cookies: [
                'refreshToken' => $this->createRefreshTokenFor($data['email'], $data['password']),
            ],
        );
        $action = app(RefreshProxyForWebClientAction::class);

        $response = $action->run($request);

        $this->assertSame('refreshToken', $response->refreshTokenCookie->getName());
    }
}
