<?php

namespace App\Containers\AppSection\Authentication\Tests\Unit\UI\API\Controllers;

use App\Containers\AppSection\Authentication\Actions\ApiLoginProxyForWebClientAction;
use App\Containers\AppSection\Authentication\DataTransferObjects\AuthResult;
use App\Containers\AppSection\Authentication\Tests\UnitTestCase;
use App\Containers\AppSection\Authentication\UI\API\Controllers\LoginProxyForWebClientController;
use App\Containers\AppSection\Authentication\UI\API\Requests\LoginProxyPasswordGrantRequest;
use PHPUnit\Framework\Attributes\CoversClass;

#[CoversClass(LoginProxyForWebClientController::class)]
final class LoginProxyForWebClientControllerTest extends UnitTestCase
{
    public function testControllerCallsCorrectAction(): void
    {
        $controller = app(LoginProxyForWebClientController::class);
        $request = LoginProxyPasswordGrantRequest::injectData();
        $actionMock = $this->mock(ApiLoginProxyForWebClientAction::class);
        $actionMock->expects()->run($request)->andReturn(AuthResult::fake());

        $controller->__invoke($request, $actionMock);
    }
}
