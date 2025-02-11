<?php

namespace App\Containers\AppSection\Authorization\Tests\Unit\UI\API\Controllers;

use App\Containers\AppSection\Authorization\Actions\ListRolePermissionsAction;
use App\Containers\AppSection\Authorization\Models\Permission;
use App\Containers\AppSection\Authorization\Tests\UnitTestCase;
use App\Containers\AppSection\Authorization\UI\API\Controllers\ListRolePermissionsController;
use App\Containers\AppSection\Authorization\UI\API\Requests\ListRolePermissionsRequest;
use PHPUnit\Framework\Attributes\CoversClass;

#[CoversClass(ListRolePermissionsController::class)]
final class ListRolePermissionsControllerTest extends UnitTestCase
{
    public function testControllerCallsCorrectAction(): void
    {
        $controller = app(ListRolePermissionsController::class);
        $request = ListRolePermissionsRequest::injectData();
        $actionMock = $this->mock(ListRolePermissionsAction::class);
        $actionMock->expects()->run($request)->andReturn(Permission::factory()->count(2)->create());

        $controller->__invoke($request, $actionMock);
    }
}
