<?php

namespace App\Containers\AppSection\User\Tests\Functional\API;

use App\Containers\AppSection\User\Models\User;
use App\Containers\AppSection\User\Tests\Functional\ApiTestCase;
use App\Containers\AppSection\User\UI\API\Controllers\DeleteUserController;
use PHPUnit\Framework\Attributes\CoversNothing;

#[CoversNothing]
final class DeleteUserTest extends ApiTestCase
{
    public function testCannotDeleteSelf(): void
    {
        $user = User::factory()->admin()->createOne();
        $this->actingAs($user);

        $response = $this->deleteJson(action(
            DeleteUserController::class,
            ['user_id' => $user->getHashedKey()],
        ));

        $response->assertUnprocessable();
    }

    public function testCanDeleteAnotherUserAsAdmin(): void
    {
        $user = User::factory()->admin()->createOne();
        $this->actingAs($user);

        $response = $this->deleteJson(action(
            DeleteUserController::class,
            ['user_id' => User::factory()->createOne()->getHashedKey()],
        ));

        $response->assertNoContent();
    }

    public function testGivenUserHasNoAccessPreventsOperation(): void
    {
        $this->actingAs(User::factory()->createOne());

        $response = $this->deleteJson(action(
            DeleteUserController::class,
            ['user_id' => User::factory()->createOne()->getHashedKey()],
        ));

        $response->assertForbidden();
    }
}
