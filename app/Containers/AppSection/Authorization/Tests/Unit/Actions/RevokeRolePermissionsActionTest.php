<?php

namespace App\Containers\AppSection\Authorization\Tests\Unit\Actions;

use App\Containers\AppSection\Authorization\Actions\RevokeRolePermissionsAction;
use App\Containers\AppSection\Authorization\Models\Permission;
use App\Containers\AppSection\Authorization\Models\Role;
use App\Containers\AppSection\Authorization\Tests\UnitTestCase;
use App\Containers\AppSection\Authorization\UI\API\Requests\RevokeRolePermissionsRequest;
use PHPUnit\Framework\Attributes\CoversClass;

#[CoversClass(RevokeRolePermissionsAction::class)]
final class RevokeRolePermissionsActionTest extends UnitTestCase
{
    public function testCanRevokeSinglePermission(): void
    {
        $role = Role::factory()->createOne();
        $permissions = Permission::factory()->count(3)->create();
        $role->givePermissionTo($permissions);
        $request = RevokeRolePermissionsRequest::injectData([
            'permission_ids' => [$permissions[1]->getHashedKey()],
        ])->withUrlParameters(['role_id' => $role->id]);
        $action = app(RevokeRolePermissionsAction::class);

        $result = $action->run($request);

        $this->assertCount(2, $result->permissions);
        $this->assertSame($permissions[0]->id, $result->permissions->first()->id);
        $this->assertSame($permissions[2]->id, $result->permissions->last()->id);
    }

    public function testCanRevokeMultiplePermissions(): void
    {
        $role = Role::factory()->createOne();
        $permissions = Permission::factory()->count(3)->create();
        $role->givePermissionTo($permissions);
        $request = RevokeRolePermissionsRequest::injectData([
            'permission_ids' => [$permissions[0]->getHashedKey(), $permissions[2]->getHashedKey()],
        ])->withUrlParameters(['role_id' => $role->id]);
        $action = app(RevokeRolePermissionsAction::class);

        $result = $action->run($request);

        $this->assertCount(1, $result->permissions);
        $this->assertSame($permissions[1]->id, $result->permissions->sole()->id);
    }
}
