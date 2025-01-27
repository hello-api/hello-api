<?php

namespace App\Containers\AppSection\Authorization\Tests\Unit\Actions;

use App\Containers\AppSection\Authorization\Actions\RemoveUserRolesAction;
use App\Containers\AppSection\Authorization\Models\Role;
use App\Containers\AppSection\Authorization\Tests\UnitTestCase;
use App\Containers\AppSection\Authorization\UI\API\Requests\RemoveUserRolesRequest;
use App\Containers\AppSection\User\Models\User;
use PHPUnit\Framework\Attributes\CoversClass;

#[CoversClass(RemoveUserRolesAction::class)]
final class RemoveUserRolesActionTest extends UnitTestCase
{
    public function testCanRemoveRole(): void
    {
        $user = User::factory()->createOne();
        $roles = Role::factory()->count(3)->create();
        $user->assignRole($roles);
        $request = RemoveUserRolesRequest::injectData([
            'role_ids' => $roles[1]->getHashedKey(),
        ])->withUrlParameters(['user_id' => $user->id]);
        $action = app(RemoveUserRolesAction::class);

        $result = $action->run($request);

        $this->assertCount(2, $result->roles);
        $this->assertSame($roles[0]->id, $result->roles->first()->id);
        $this->assertSame($roles[2]->id, $result->roles->last()->id);
    }

    public function testCanRemoveRoles(): void
    {
        $user = User::factory()->createOne();
        $roles = Role::factory()->count(3)->create();
        $user->assignRole($roles);
        $request = RemoveUserRolesRequest::injectData([
            'role_ids' => [$roles[0]->getHashedKey(), $roles[2]->getHashedKey()],
        ])->withUrlParameters(['user_id' => $user->id]);
        $action = app(RemoveUserRolesAction::class);

        $result = $action->run($request);

        $this->assertCount(1, $result->roles);
        $this->assertSame($roles[1]->id, $result->roles->sole()->id);
    }
}
