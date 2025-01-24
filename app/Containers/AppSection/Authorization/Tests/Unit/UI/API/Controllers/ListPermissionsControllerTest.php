<?php

namespace App\Containers\AppSection\Authorization\Tests\Unit\UI\API\Controllers;

use App\Containers\AppSection\Authorization\Actions\ListPermissionsAction;
use App\Containers\AppSection\Authorization\Models\Permission;
use App\Containers\AppSection\Authorization\Tests\UnitTestCase;
use App\Containers\AppSection\Authorization\UI\API\Controllers\ListPermissionsController;
use App\Containers\AppSection\Authorization\UI\API\Requests\ListPermissionsRequest;
use Illuminate\Pagination\LengthAwarePaginator;
use PHPUnit\Framework\Attributes\CoversClass;

#[CoversClass(ListPermissionsController::class)]
final class ListPermissionsControllerTest extends UnitTestCase
{
    public function testControllerCallsCorrectAction(): void
    {
        $controller = app(ListPermissionsController::class);
        $request = ListPermissionsRequest::injectData();
        $actionMock = $this->mock(ListPermissionsAction::class);
        $actionMock->expects()->run()->andReturn(
            new LengthAwarePaginator(
                Permission::factory()->count(2)->create(),
                2,
                1,
            ),
        );

        $controller->__invoke($request, $actionMock);
    }
}
