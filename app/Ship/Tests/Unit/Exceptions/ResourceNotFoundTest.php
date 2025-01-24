<?php

namespace App\Ship\Tests\Unit\Exceptions;

use App\Ship\Exceptions\ResourceNotFound;
use App\Ship\Tests\ShipTestCase;
use PHPUnit\Framework\Attributes\CoversClass;

#[CoversClass(ResourceNotFound::class)]
final class ResourceNotFoundTest extends ShipTestCase
{
    public function testException(): void
    {
        $this->expectExceptionMessage('Resource not found.');
        $exception = ResourceNotFound::create();
        $this->assertSame(404, $exception->getStatusCode());

        throw $exception;
    }
}
