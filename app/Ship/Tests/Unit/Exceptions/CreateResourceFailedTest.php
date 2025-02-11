<?php

namespace App\Ship\Tests\Unit\Exceptions;

use App\Ship\Exceptions\ResourceCreationFailed;
use App\Ship\Tests\ShipTestCase;
use PHPUnit\Framework\Attributes\CoversClass;

#[CoversClass(ResourceCreationFailed::class)]
final class CreateResourceFailedTest extends ShipTestCase
{
    public function testException(): void
    {
        $this->expectExceptionMessage('Resource creation failed.');
        $exception = ResourceCreationFailed::create();
        $this->assertSame(417, $exception->getStatusCode());

        throw $exception;
    }
}
