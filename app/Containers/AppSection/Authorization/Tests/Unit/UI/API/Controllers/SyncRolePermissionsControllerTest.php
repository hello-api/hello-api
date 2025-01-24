<?php

namespace App\Containers\AppSection\Authorization\Tests\Unit\UI\API\Controllers;

use App\Containers\AppSection\Authorization\Actions\SyncRolePermissionsAction;
use App\Containers\AppSection\Authorization\Models\Role;
use App\Containers\AppSection\Authorization\Tests\UnitTestCase;
use App\Containers\AppSection\Authorization\UI\API\Controllers\SyncRolePermissionsController;
use App\Containers\AppSection\Authorization\UI\API\Requests\SyncRolePermissionsRequest;
use PHPUnit\Framework\Attributes\CoversClass;

#[CoversClass(SyncRolePermissionsController::class)]
final class SyncRolePermissionsControllerTest extends UnitTestCase
{
    public function testControllerCallsCorrectAction(): void
    {
        $controller = app(SyncRolePermissionsController::class);
        $request = SyncRolePermissionsRequest::injectData();
        $actionMock = $this->mock(SyncRolePermissionsAction::class);
        $actionMock->expects()->run($request)->andReturn(Role::factory()->createOne());

        $controller->__invoke($request, $actionMock);
    }
}
