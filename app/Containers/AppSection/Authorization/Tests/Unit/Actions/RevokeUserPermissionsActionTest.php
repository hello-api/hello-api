<?php

namespace App\Containers\AppSection\Authorization\Tests\Unit\Actions;

use App\Containers\AppSection\Authorization\Actions\RevokeUserPermissionsAction;
use App\Containers\AppSection\Authorization\Models\Permission;
use App\Containers\AppSection\Authorization\Tests\UnitTestCase;
use App\Containers\AppSection\Authorization\UI\API\Requests\RevokeUserPermissionsRequest;
use App\Containers\AppSection\User\Models\User;
use PHPUnit\Framework\Attributes\CoversClass;

#[CoversClass(RevokeUserPermissionsAction::class)]
final class RevokeUserPermissionsActionTest extends UnitTestCase
{
    public function testCanRevokeSinglePermission(): void
    {
        $user = User::factory()->createOne();
        $permissions = Permission::factory()->count(3)->create();
        $user->givePermissionTo($permissions);
        $request = RevokeUserPermissionsRequest::injectData([
            'permission_ids' => [$permissions[1]->getHashedKey()],
        ])->withUrlParameters(['user_id' => $user->id]);
        $action = app(RevokeUserPermissionsAction::class);

        $result = $action->run($request);

        $this->assertCount(2, $result->permissions);
        $this->assertSame($permissions[0]->id, $result->permissions->first()->id);
        $this->assertSame($permissions[2]->id, $result->permissions->last()->id);
    }

    public function testCanRevokeMultiplePermissions(): void
    {
        $user = User::factory()->createOne();
        $permissions = Permission::factory()->count(3)->create();
        $user->givePermissionTo($permissions);
        $request = RevokeUserPermissionsRequest::injectData([
            'permission_ids' => [$permissions[0]->getHashedKey(), $permissions[2]->getHashedKey()],
        ])->withUrlParameters(['user_id' => $user->id]);
        $action = app(RevokeUserPermissionsAction::class);

        $result = $action->run($request);

        $this->assertCount(1, $result->permissions);
        $this->assertSame($permissions[1]->id, $result->permissions->sole()->id);
    }
}
