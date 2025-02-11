<?php

namespace App\Containers\AppSection\Authorization\Tests\Unit\UI\API\Controllers;

use App\Containers\AppSection\Authorization\Actions\ListRolesAction;
use App\Containers\AppSection\Authorization\Models\Role;
use App\Containers\AppSection\Authorization\Tests\UnitTestCase;
use App\Containers\AppSection\Authorization\UI\API\Controllers\ListRolesController;
use App\Containers\AppSection\Authorization\UI\API\Requests\ListRolesRequest;
use Illuminate\Pagination\LengthAwarePaginator;
use PHPUnit\Framework\Attributes\CoversClass;

#[CoversClass(ListRolesController::class)]
final class ListRolesControllerTest extends UnitTestCase
{
    public function testControllerCallsCorrectAction(): void
    {
        $controller = app(ListRolesController::class);
        $request = ListRolesRequest::injectData();
        $actionMock = $this->mock(ListRolesAction::class);
        $actionMock->expects()->run()->andReturn(
            new LengthAwarePaginator(
                Role::factory()->count(2)->create(),
                2,
                1,
            ),
        );

        $controller->__invoke($request, $actionMock);
    }
}
