<?php

namespace App\Containers\AppSection\Authentication\Tests\Unit\Actions;

use App\Containers\AppSection\Authentication\Actions\ApiLogoutAction;
use App\Containers\AppSection\Authentication\Tasks\CallOAuthServerTask;
use App\Containers\AppSection\Authentication\Tests\UnitTestCase;
use App\Containers\AppSection\Authentication\UI\API\Requests\LogoutRequest;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;

#[UsesClass(CallOAuthServerTask::class)]
#[CoversClass(ApiLogoutAction::class)]
final class ApiLogoutActionTest extends UnitTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->setupPasswordGrantClient();
    }

    public function testApiLogoutAction(): void
    {
        $data = [
            'email' => 'gandalf@the.grey',
            'password' => 'youShallNotPass',
        ];
        $this->getTestingUser($data);
        $accessToken = $this->createAccessTokenFor($data['email'], $data['password']);
        $request = LogoutRequest::injectData(server: ['HTTP_AUTHORIZATION' => 'Bearer ' . $accessToken]);
        $action = app(ApiLogoutAction::class);

        $action->run($request);

        $this->assertTrue(true);
    }

    private function createAccessTokenFor(string $email, string $password): string
    {
        return app(CallOAuthServerTask::class)->run($this->enrichWithPasswordGrantFields($email, $password))->accessToken;
    }
}
