<?php

namespace App\Containers\AppSection\Authentication\Tests\Unit\UI\API\Controllers;

use App\Containers\AppSection\Authentication\Actions\RefreshProxyForWebClientAction;
use App\Containers\AppSection\Authentication\DataTransferObjects\AuthResult;
use App\Containers\AppSection\Authentication\Tests\UnitTestCase;
use App\Containers\AppSection\Authentication\UI\API\Controllers\RefreshProxyForWebClientController;
use App\Containers\AppSection\Authentication\UI\API\Requests\RefreshProxyRequest;
use PHPUnit\Framework\Attributes\CoversClass;

#[CoversClass(RefreshProxyForWebClientController::class)]
final class RefreshProxyForWebClientControllerTest extends UnitTestCase
{
    public function testControllerCallsCorrectAction(): void
    {
        $controller = app(RefreshProxyForWebClientController::class);
        $request = RefreshProxyRequest::injectData();
        $actionMock = $this->mock(RefreshProxyForWebClientAction::class);
        $actionMock->expects()->run($request)->andReturn(AuthResult::fake());

        $controller->__invoke($request, $actionMock);
    }
}
