<?php

namespace App\Containers\AppSection\User\Tests\Functional\API;

use App\Containers\AppSection\User\Models\User;
use App\Containers\AppSection\User\Tests\Functional\ApiTestCase;
use PHPUnit\Framework\Attributes\CoversNothing;

#[CoversNothing]
final class DeleteUserTest extends ApiTestCase
{
    protected string $endpoint = 'delete@v1/users/{user_id}';

    protected array $access = [
        'permissions' => null,
        'roles' => null,
    ];

    public function testCanDeleteSelfAsAdmin(): void
    {
        $this->testingUser = User::factory()->admin()->createOne();

        $response = $this->injectId($this->testingUser->id, replace: '{user_id}')->makeCall();

        $response->assertNoContent();
    }

    public function testCanDeleteAnotherUserAsAdmin(): void
    {
        $this->testingUser = User::factory()->admin()->createOne();

        $response = $this->injectId(User::factory()->createOne()->id, replace: '{user_id}')->makeCall();

        $response->assertNoContent();
    }
}
