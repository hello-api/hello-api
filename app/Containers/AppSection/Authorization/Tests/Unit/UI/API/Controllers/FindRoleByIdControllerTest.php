<?php

namespace App\Containers\AppSection\Authorization\Tests\Unit\UI\API\Controllers;

use App\Containers\AppSection\Authorization\Actions\FindRoleByIdAction;
use App\Containers\AppSection\Authorization\Models\Role;
use App\Containers\AppSection\Authorization\Tests\UnitTestCase;
use App\Containers\AppSection\Authorization\UI\API\Controllers\FindRoleByIdController;
use App\Containers\AppSection\Authorization\UI\API\Requests\FindRoleByIdRequest;
use PHPUnit\Framework\Attributes\CoversClass;

#[CoversClass(FindRoleByIdController::class)]
final class FindRoleByIdControllerTest extends UnitTestCase
{
    public function testControllerCallsCorrectAction(): void
    {
        $controller = app(FindRoleByIdController::class);
        $request = FindRoleByIdRequest::injectData();
        $actionMock = $this->mock(FindRoleByIdAction::class);
        $actionMock->expects()->run($request)->andReturn(Role::factory()->createOne());

        $controller->__invoke($request, $actionMock);
    }
}
