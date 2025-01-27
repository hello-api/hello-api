<?php

namespace App\Containers\AppSection\Authentication\Tests\Unit\Exceptions;

use App\Containers\AppSection\Authentication\Exceptions\InvalidResetPasswordToken;
use App\Containers\AppSection\Authentication\Tests\UnitTestCase;
use PHPUnit\Framework\Attributes\CoversClass;

#[CoversClass(InvalidResetPasswordToken::class)]
final class InvalidResetPasswordTokenTest extends UnitTestCase
{
    public function testException(): void
    {
        $this->expectExceptionMessage('Invalid Reset Password Token.');
        $exception = InvalidResetPasswordToken::create();
        $this->assertSame(422, $exception->getStatusCode());

        throw $exception;
    }
}
