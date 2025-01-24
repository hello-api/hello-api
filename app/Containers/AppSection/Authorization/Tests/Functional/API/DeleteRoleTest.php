<?php

namespace App\Containers\AppSection\Authorization\Tests\Functional\API;

use App\Containers\AppSection\Authorization\Models\Role;
use App\Containers\AppSection\Authorization\Tests\Functional\ApiTestCase;
use PHPUnit\Framework\Attributes\CoversNothing;

#[CoversNothing]
final class DeleteRoleTest extends ApiTestCase
{
    protected string $endpoint = 'delete@v1/roles/{role_id}';

    protected array $access = [
        'permissions' => 'manage-roles',
        'roles' => null,
    ];

    public function testCanDeleteRole(): void
    {
        $role = Role::factory()->createOne();

        $response = $this->injectId($role->id, replace: '{role_id}')->makeCall();

        $response->assertNoContent();
    }
}
