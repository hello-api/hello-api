<?php

namespace App\Containers\AppSection\Authorization\Tests\Unit\Actions;

use App\Containers\AppSection\Authorization\Actions\GivePermissionsToRoleAction;
use App\Containers\AppSection\Authorization\Models\Permission;
use App\Containers\AppSection\Authorization\Models\Role;
use App\Containers\AppSection\Authorization\Tests\UnitTestCase;
use App\Containers\AppSection\Authorization\UI\API\Requests\GivePermissionsToRoleRequest;
use PHPUnit\Framework\Attributes\CoversClass;

#[CoversClass(GivePermissionsToRoleAction::class)]
final class GivePermissionsToRoleActionTest extends UnitTestCase
{
    public function testCanGiveSinglePermission(): void
    {
        $role = Role::factory()->createOne();
        $permission = Permission::factory()->createOne();
        $data = [
            'permission_ids' => [$permission->getHashedKey()],
        ];
        $request = GivePermissionsToRoleRequest::injectData($data)
            ->withUrlParameters(['role_id' => $role->id]);
        $action = app(GivePermissionsToRoleAction::class);

        $result = $action->run($request);

        $this->assertSame($result->id, $role->id);
        $this->assertTrue($result->hasPermissionTo($permission->name));
    }

    public function testCanGiveMultiplePermissions(): void
    {
        $role = Role::factory()->createOne();
        $permissionA = Permission::factory()->createOne();
        $permissionB = Permission::factory()->createOne();
        $data = [
            'permission_ids' => [$permissionA->getHashedKey(), $permissionB->getHashedKey()],
        ];
        $request = GivePermissionsToRoleRequest::injectData($data)
        ->withUrlParameters(['role_id' => $role->id]);
        $action = app(GivePermissionsToRoleAction::class);

        $result = $action->run($request);

        $this->assertSame($result->id, $role->id);
        $this->assertTrue($result->hasAllPermissions([$permissionA->name, $permissionB->name]));
    }
}
