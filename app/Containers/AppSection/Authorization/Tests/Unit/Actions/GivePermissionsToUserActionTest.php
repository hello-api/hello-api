<?php

namespace App\Containers\AppSection\Authorization\Tests\Unit\Actions;

use App\Containers\AppSection\Authorization\Actions\GivePermissionsToUserAction;
use App\Containers\AppSection\Authorization\Models\Permission;
use App\Containers\AppSection\Authorization\Tests\UnitTestCase;
use App\Containers\AppSection\Authorization\UI\API\Requests\GivePermissionsToUserRequest;
use App\Containers\AppSection\User\Models\User;
use PHPUnit\Framework\Attributes\CoversClass;

#[CoversClass(GivePermissionsToUserAction::class)]
final class GivePermissionsToUserActionTest extends UnitTestCase
{
    public function testCanGiveSinglePermission(): void
    {
        $user = User::factory()->createOne();
        $permission = Permission::factory()->createOne();
        $data = [
            'permission_ids' => [$permission->getHashedKey()],
        ];
        $request = GivePermissionsToUserRequest::injectData($data)->withUrlParameters(['user_id' => $user->id]);
        $action = app(GivePermissionsToUserAction::class);

        $result = $action->run($request);

        $this->assertSame($result->id, $user->id);
        $this->assertTrue($result->hasPermissionTo($permission->name));
    }

    public function testCanGiveMultiplePermissions(): void
    {
        $user = User::factory()->createOne();
        $permissionA = Permission::factory()->createOne();
        $permissionB = Permission::factory()->createOne();
        $data = [
            'permission_ids' => [$permissionA->getHashedKey(), $permissionB->getHashedKey()],
        ];
        $request = GivePermissionsToUserRequest::injectData($data)->withUrlParameters(['user_id' => $user->id]);
        $action = app(GivePermissionsToUserAction::class);

        $result = $action->run($request);

        $this->assertSame($result->id, $user->id);
        $this->assertTrue($result->hasAllPermissions([$permissionA->name, $permissionB->name]));
    }
}
