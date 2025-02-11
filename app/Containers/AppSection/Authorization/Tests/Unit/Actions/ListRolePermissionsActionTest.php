<?php

namespace App\Containers\AppSection\Authorization\Tests\Unit\Actions;

use App\Containers\AppSection\Authorization\Actions\ListRolePermissionsAction;
use App\Containers\AppSection\Authorization\Models\Permission;
use App\Containers\AppSection\Authorization\Models\Role;
use App\Containers\AppSection\Authorization\Tests\UnitTestCase;
use App\Containers\AppSection\Authorization\UI\API\Requests\ListRolePermissionsRequest;
use PHPUnit\Framework\Attributes\CoversClass;

#[CoversClass(ListRolePermissionsAction::class)]
final class ListRolePermissionsActionTest extends UnitTestCase
{
    public function testCanListPermissions(): void
    {
        $role = Role::factory()->createOne()
            ->givePermissionTo(Permission::factory()->count(3)->create());
        $request = ListRolePermissionsRequest::injectData()->withUrlParameters(['role_id' => $role->id]);
        $action = app(ListRolePermissionsAction::class);

        $result = $action->run($request);

        $this->assertCount(3, $result);
    }
}
