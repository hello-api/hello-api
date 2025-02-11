<?php

namespace App\Containers\AppSection\Authorization\Tests\Unit\Actions;

use App\Containers\AppSection\Authorization\Actions\SyncUserRolesAction;
use App\Containers\AppSection\Authorization\Models\Role;
use App\Containers\AppSection\Authorization\Tests\UnitTestCase;
use App\Containers\AppSection\Authorization\UI\API\Requests\SyncUserRolesRequest;
use App\Containers\AppSection\User\Models\User;
use PHPUnit\Framework\Attributes\CoversClass;

#[CoversClass(SyncUserRolesAction::class)]
final class SyncUserRolesActionTest extends UnitTestCase
{
    public function testCanSyncPermission(): void
    {
        $user = User::factory()->createOne();
        $roles = Role::factory()->count(3)->create();
        $user->assignRole($roles);
        $this->assertCount(3, $user->roles);
        $request = SyncUserRolesRequest::injectData([
            'role_ids' => [$roles[1]->getHashedKey()],
        ])->withUrlParameters(['user_id' => $user->id]);
        $action = app(SyncUserRolesAction::class);

        $result = $action->run($request);

        $this->assertCount(1, $result->roles);
        $this->assertSame($roles[1]->id, $result->roles->sole()->id);
    }

    public function testCanSyncPermissions(): void
    {
        $user = User::factory()->createOne();
        $roles = Role::factory()->count(3)->create();
        $user->assignRole($roles);
        $this->assertCount(3, $user->roles);
        $request = SyncUserRolesRequest::injectData([
            'role_ids' => [$roles[0]->getHashedKey(), $roles[2]->getHashedKey()],
        ])->withUrlParameters(['user_id' => $user->id]);
        $action = app(SyncUserRolesAction::class);

        $result = $action->run($request);

        $this->assertCount(2, $result->roles);
        $this->assertSame($roles[0]->id, $result->roles->first()->id);
        $this->assertSame($roles[2]->id, $result->roles->last()->id);
    }
}
