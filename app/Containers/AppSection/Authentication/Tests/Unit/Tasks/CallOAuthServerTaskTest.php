<?php

namespace App\Containers\AppSection\Authentication\Tests\Unit\Tasks;

use App\Containers\AppSection\Authentication\Exceptions\LoginFailed;
use App\Containers\AppSection\Authentication\Tasks\CallOAuthServerTask;
use App\Containers\AppSection\Authentication\Tests\UnitTestCase;
use App\Containers\AppSection\User\Models\User;
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
        User::factory()->createOne($credentials);
        $data = $this->enrichWithPasswordGrantFields($credentials['email'], $credentials['password']);
        $task = app(CallOAuthServerTask::class);

        $task->run($data);

        $this->expectNotToPerformAssertions();
    }

    public function testCallOAuthServerWithInvalidCredentials(): void
    {
        $this->expectException(LoginFailed::class);

        User::factory()->createOne(['email' => 'gandalf@the.grey', 'password' => 'youShallNotPass']);
        $data = $this->enrichWithPasswordGrantFields('nonexisting@email.void', 'invalidPassword');
        $task = app(CallOAuthServerTask::class);

        $task->run($data);
    }
}
