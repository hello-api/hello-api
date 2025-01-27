<?php

namespace App\Containers\AppSection\Authorization\Tests\Functional\API;

use App\Containers\AppSection\Authorization\Models\Permission;
use App\Containers\AppSection\Authorization\Models\Role;
use App\Containers\AppSection\Authorization\Tests\Functional\ApiTestCase;
use PHPUnit\Framework\Attributes\CoversNothing;

#[CoversNothing]
final class ListRolePermissionsTest extends ApiTestCase
{
    protected string $endpoint = 'get@v1/roles/{role_id}/permissions';

    protected array $access = [
        'permissions' => 'manage-roles',
        'roles' => null,
    ];

    public function testGetRolePermissions(): void
    {
        $role = Role::factory()->createOne();
        $permission = Permission::factory()->createOne();
        $role->givePermissionTo([$permission]);

        $response = $this->injectId($role->id, replace: '{role_id}')->makeCall();

        $response->assertOk();
        $responseContent = $this->getResponseContentObject();
        $this->assertSame($permission->name, $responseContent->data[0]->name);
    }
}
