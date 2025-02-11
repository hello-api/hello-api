<?php

namespace App\Containers\AppSection\Authorization\Tests\Unit\UI\API\Controllers;

use App\Containers\AppSection\Authorization\Actions\ListUserRolesAction;
use App\Containers\AppSection\Authorization\Models\Role;
use App\Containers\AppSection\Authorization\Tests\UnitTestCase;
use App\Containers\AppSection\Authorization\UI\API\Controllers\ListUserRolesController;
use App\Containers\AppSection\Authorization\UI\API\Requests\ListUserRolesRequest;
use PHPUnit\Framework\Attributes\CoversClass;

#[CoversClass(ListUserRolesController::class)]
final class ListUserRolesControllerTest extends UnitTestCase
{
    public function testControllerCallsCorrectAction(): void
    {
        $controller = app(ListUserRolesController::class);
        $request = ListUserRolesRequest::injectData();
        $actionMock = $this->mock(ListUserRolesAction::class);
        $actionMock->expects()->run($request)->andReturn(Role::factory()->count(2)->create());

        $controller->__invoke($request, $actionMock);
    }
}
