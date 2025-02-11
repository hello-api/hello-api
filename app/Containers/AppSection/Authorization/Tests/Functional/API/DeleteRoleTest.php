<?php

namespace App\Containers\AppSection\Authorization\Tests\Functional\API;

use App\Containers\AppSection\Authorization\Models\Role;
use App\Containers\AppSection\Authorization\Tests\Functional\ApiTestCase;
use App\Containers\AppSection\Authorization\UI\API\Controllers\DeleteRoleController;
use App\Containers\AppSection\User\Models\User;
use PHPUnit\Framework\Attributes\CoversNothing;

#[CoversNothing]
final class DeleteRoleTest extends ApiTestCase
{
    public function testCanDeleteRole(): void
    {
        $this->actingAs(User::factory()->admin()->createOne());
        $role = Role::factory()->createOne();

        $response = $this->deleteJson(action(DeleteRoleController::class, ['role_id' => $role->getHashedKey()]));

        $response->assertNoContent();
    }

    public function testGivenUserHasNoAccessPreventsOperation(): void
    {
        $this->actingAs(User::factory()->createOne());
        $role = Role::factory()->createOne();

        $response = $this->deleteJson(action(DeleteRoleController::class, ['role_id' => $role->getHashedKey()]));

        $response->assertForbidden();
    }
}
