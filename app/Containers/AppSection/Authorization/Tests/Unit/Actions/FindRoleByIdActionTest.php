<?php

namespace App\Containers\AppSection\Authorization\Tests\Unit\Actions;

use App\Containers\AppSection\Authorization\Actions\FindRoleByIdAction;
use App\Containers\AppSection\Authorization\Models\Role;
use App\Containers\AppSection\Authorization\Tasks\FindRoleTask;
use App\Containers\AppSection\Authorization\Tests\UnitTestCase;
use App\Containers\AppSection\Authorization\UI\API\Requests\FindRoleByIdRequest;
use PHPUnit\Framework\Attributes\CoversClass;

#[CoversClass(FindRoleByIdAction::class)]
final class FindRoleByIdActionTest extends UnitTestCase
{
    public function testCanFindRole(): void
    {
        $role = Role::factory()->createOne();
        $request = FindRoleByIdRequest::injectData()->withUrlParameters(['role_id' => $role->id]);
        $taskMock = $this->partialMock(FindRoleTask::class);
        $taskMock->expects('run')->once()->with($request->role_id)->andReturn($role);

        app(FindRoleByIdAction::class)->run($request);
    }
}
