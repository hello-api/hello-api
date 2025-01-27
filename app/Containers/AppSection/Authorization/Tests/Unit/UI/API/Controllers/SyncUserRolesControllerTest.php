<?php

namespace App\Containers\AppSection\Authorization\Tests\Unit\UI\API\Controllers;

use App\Containers\AppSection\Authorization\Actions\SyncUserRolesAction;
use App\Containers\AppSection\Authorization\Tests\UnitTestCase;
use App\Containers\AppSection\Authorization\UI\API\Controllers\SyncUserRolesController;
use App\Containers\AppSection\Authorization\UI\API\Requests\SyncUserRolesRequest;
use App\Containers\AppSection\User\Models\User;
use PHPUnit\Framework\Attributes\CoversClass;

#[CoversClass(SyncUserRolesController::class)]
final class SyncUserRolesControllerTest extends UnitTestCase
{
    public function testControllerCallsCorrectAction(): void
    {
        $controller = app(SyncUserRolesController::class);
        $request = SyncUserRolesRequest::injectData();
        $actionMock = $this->mock(SyncUserRolesAction::class);
        $actionMock->expects()->run($request)->andReturn(User::factory()->createOne());

        $controller->__invoke($request, $actionMock);
    }
}
