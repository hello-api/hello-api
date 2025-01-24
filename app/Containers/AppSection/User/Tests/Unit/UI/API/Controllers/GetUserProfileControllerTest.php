<?php

namespace App\Containers\AppSection\User\Tests\Unit\UI\API\Controllers;

use App\Containers\AppSection\User\Actions\GetUserProfileAction;
use App\Containers\AppSection\User\Models\User;
use App\Containers\AppSection\User\Tests\UnitTestCase;
use App\Containers\AppSection\User\UI\API\Controllers\GetUserProfileController;
use PHPUnit\Framework\Attributes\CoversClass;

#[CoversClass(GetUserProfileController::class)]
final class GetUserProfileControllerTest extends UnitTestCase
{
    public function testControllerCallsCorrectAction(): void
    {
        $controller = app(GetUserProfileController::class);
        $actionMock = $this->mock(GetUserProfileAction::class);
        $actionMock->expects()->run()->andReturn(User::factory()->createOne());

        $controller->__invoke($actionMock);
    }
}
