<?php

namespace App\Containers\AppSection\Authorization\Tests\Unit\Actions;

use App\Containers\AppSection\Authorization\Actions\ListUserRolesAction;
use App\Containers\AppSection\Authorization\Models\Role;
use App\Containers\AppSection\Authorization\Tests\UnitTestCase;
use App\Containers\AppSection\Authorization\UI\API\Requests\ListUserRolesRequest;
use App\Containers\AppSection\User\Models\User;
use PHPUnit\Framework\Attributes\CoversClass;

#[CoversClass(ListUserRolesAction::class)]
final class ListUserRolesActionTest extends UnitTestCase
{
    public function testCanListRoles(): void
    {
        $user = User::factory()->createOne()
            ->assignRole(Role::factory()->count(3)->create());
        $request = ListUserRolesRequest::injectData()->withUrlParameters(['user_id' => $user->id]);
        $action = app(ListUserRolesAction::class);

        $result = $action->run($request);

        $this->assertCount(3, $result);
    }
}
