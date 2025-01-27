<?php

namespace App\Containers\AppSection\Authorization\Tests\Unit\UI\API\Controllers;

use App\Containers\AppSection\Authorization\Actions\RevokeUserPermissionsAction;
use App\Containers\AppSection\Authorization\Tests\UnitTestCase;
use App\Containers\AppSection\Authorization\UI\API\Controllers\RevokeUserPermissionsController;
use App\Containers\AppSection\Authorization\UI\API\Requests\RevokeUserPermissionsRequest;
use App\Containers\AppSection\User\Models\User;
use PHPUnit\Framework\Attributes\CoversClass;

#[CoversClass(RevokeUserPermissionsController::class)]
final class RevokeUserPermissionsControllerTest extends UnitTestCase
{
    public function testControllerCallsCorrectAction(): void
    {
        $controller = app(RevokeUserPermissionsController::class);
        $request = RevokeUserPermissionsRequest::injectData();
        $actionMock = $this->mock(RevokeUserPermissionsAction::class);
        $actionMock->expects()->run($request)->andReturn(User::factory()->createOne());

        $controller->__invoke($request, $actionMock);
    }
}
