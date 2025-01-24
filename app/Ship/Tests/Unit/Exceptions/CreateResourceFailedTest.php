<?php

namespace App\Ship\Tests\Unit\Exceptions;

use App\Ship\Exceptions\CreateResourceFailed;
use App\Ship\Tests\ShipTestCase;
use PHPUnit\Framework\Attributes\CoversClass;

#[CoversClass(CreateResourceFailed::class)]
final class CreateResourceFailedTest extends ShipTestCase
{
    public function testException(): void
    {
        $this->expectExceptionMessage('Resource creation failed.');
        $exception = CreateResourceFailed::create();
        $this->assertSame(417, $exception->getStatusCode());

        throw $exception;
    }
}
