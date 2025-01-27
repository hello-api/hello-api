<?php

namespace App\Containers\AppSection\Authentication\Tests\Unit\Tasks;

use App\Containers\AppSection\Authentication\Exceptions\LoginFailed;
use App\Containers\AppSection\Authentication\Tasks\CallOAuthServerTask;
use App\Containers\AppSection\Authentication\Tests\UnitTestCase;
use PHPUnit\Framework\Attributes\CoversClass;

#[CoversClass(CallOAuthServerTask::class)]
final class CallOAuthServerTaskTest extends UnitTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->setupPasswordGrantClient();
    }

    public function testCallOAuthServer(): void
    {
        $credentials = [
            'email' => 'gandalf@the.grey',
            'password' => 'youShallNotPass',
        ];
        $this->getTestingUser($credentials);
        $data = $this->enrichWithPasswordGrantFields($credentials['email'], $credentials['password']);
        $task = app(CallOAuthServerTask::class);

        $task->run($data);

        $this->expectNotToPerformAssertions();
    }

    public function testCallOAuthServerWithInvalidCredentials(): void
    {
        $this->expectException(LoginFailed::class);

        $this->getTestingUser(['email' => 'gandalf@the.grey', 'password' => 'youShallNotPass']);
        $data = $this->enrichWithPasswordGrantFields('nonexisting@email.void', 'invalidPassword');
        $task = app(CallOAuthServerTask::class);

        $task->run($data);
    }
}
