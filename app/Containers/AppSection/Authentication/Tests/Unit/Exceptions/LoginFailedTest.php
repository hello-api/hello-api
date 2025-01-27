<?php

namespace App\Containers\AppSection\Authentication\Tests\Unit\Exceptions;

use App\Containers\AppSection\Authentication\Exceptions\LoginFailed;
use App\Containers\AppSection\Authentication\Tests\UnitTestCase;
use PHPUnit\Framework\Attributes\CoversClass;

#[CoversClass(LoginFailed::class)]
final class LoginFailedTest extends UnitTestCase
{
    public function testException(): void
    {
        $this->expectExceptionMessage('Login Failed.');
        $exception = LoginFailed::create();
        $this->assertSame(422, $exception->getStatusCode());

        throw $exception;
    }
}
