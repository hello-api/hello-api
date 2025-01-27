<?php

namespace App\Containers\AppSection\Authorization\Tests\Unit\UI\API\Controllers;

use App\Containers\AppSection\Authorization\Actions\RemoveUserRolesAction;
use App\Containers\AppSection\Authorization\Tests\UnitTestCase;
use App\Containers\AppSection\Authorization\UI\API\Controllers\RemoveUserRolesController;
use App\Containers\AppSection\Authorization\UI\API\Requests\RemoveUserRolesRequest;
use App\Containers\AppSection\User\Models\User;
use PHPUnit\Framework\Attributes\CoversClass;

#[CoversClass(RemoveUserRolesController::class)]
final class RemoveUserRolesControllerTest extends UnitTestCase
{
    public function testControllerCallsCorrectAction(): void
    {
        $controller = app(RemoveUserRolesController::class);
        $request = RemoveUserRolesRequest::injectData();
        $actionMock = $this->mock(RemoveUserRolesAction::class);
        $actionMock->expects()->run($request)->andReturn(User::factory()->createOne());

        $controller->__invoke($request, $actionMock);
    }
}
