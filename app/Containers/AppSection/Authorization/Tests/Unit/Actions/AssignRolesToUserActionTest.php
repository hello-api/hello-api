<?php

namespace App\Containers\AppSection\Authorization\Tests\Unit\Actions;

use App\Containers\AppSection\Authorization\Actions\AssignRolesToUserAction;
use App\Containers\AppSection\Authorization\Models\Role;
use App\Containers\AppSection\Authorization\Tests\UnitTestCase;
use App\Containers\AppSection\Authorization\UI\API\Requests\AssignRolesToUserRequest;
use App\Containers\AppSection\User\Models\User;
use PHPUnit\Framework\Attributes\CoversClass;

#[CoversClass(AssignRolesToUserAction::class)]
final class AssignRolesToUserActionTest extends UnitTestCase
{
    public function testCanAssignSingleRole(): void
    {
        $user = User::factory()->createOne();
        $role = Role::factory()->createOne();
        $data = [
            'user_id' => $user->getHashedKey(),
            'role_ids' => [$role->getHashedKey()],
        ];
        $request = AssignRolesToUserRequest::injectData($data)
        ->withUrlParameters(['user_id' => $user->id]);
        $action = app(AssignRolesToUserAction::class);

        $result = $action->run($request);

        $this->assertSame($result->id, $user->id);
        $this->assertTrue($result->hasRole($role->name));
    }

    public function testCanAssignMultipleRole(): void
    {
        $user = User::factory()->createOne();
        $roleA = Role::factory()->createOne();
        $roleB = Role::factory()->createOne();
        $data = [
            'user_id' => $user->getHashedKey(),
            'role_ids' => [$roleA->getHashedKey(), $roleB->getHashedKey()],
        ];
        $request = AssignRolesToUserRequest::injectData($data)
            ->withUrlParameters(['user_id' => $user->id]);
        $action = app(AssignRolesToUserAction::class);

        $result = $action->run($request);

        $this->assertSame($result->id, $user->id);
        $this->assertTrue($result->hasAllRoles([$roleA->name, $roleB->name]));
    }
}
