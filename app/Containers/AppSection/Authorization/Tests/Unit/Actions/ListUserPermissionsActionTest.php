<?php

namespace App\Containers\AppSection\Authorization\Tests\Unit\Actions;

use App\Containers\AppSection\Authorization\Actions\ListUserPermissionsAction;
use App\Containers\AppSection\Authorization\Models\Permission;
use App\Containers\AppSection\Authorization\Tests\UnitTestCase;
use App\Containers\AppSection\Authorization\UI\API\Requests\ListUserPermissionsRequest;
use App\Containers\AppSection\User\Models\User;
use PHPUnit\Framework\Attributes\CoversClass;

#[CoversClass(ListUserPermissionsAction::class)]
final class ListUserPermissionsActionTest extends UnitTestCase
{
    public function testCanListPermissions(): void
    {
        $user = User::factory()->createOne()
            ->givePermissionTo(Permission::factory()->count(3)->create());
        $request = ListUserPermissionsRequest::injectData()->withUrlParameters(['user_id' => $user->id]);
        $action = app(ListUserPermissionsAction::class);

        $result = $action->run($request);

        $this->assertCount(3, $result);
    }
}
