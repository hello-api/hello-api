<?php

namespace App\Containers\AppSection\Authentication\Tests\Unit\Exceptions;

use App\Containers\AppSection\Authentication\Exceptions\InvalidEmailVerificationData;
use App\Containers\AppSection\Authentication\Tests\UnitTestCase;
use PHPUnit\Framework\Attributes\CoversClass;

#[CoversClass(InvalidEmailVerificationData::class)]
final class InvalidEmailVerificationDataTest extends UnitTestCase
{
    public function testException(): void
    {
        $this->expectExceptionMessage('Invalid Email Verification Data.');
        $exception = InvalidEmailVerificationData::create();
        $this->assertSame(422, $exception->getStatusCode());

        throw $exception;
    }
}
