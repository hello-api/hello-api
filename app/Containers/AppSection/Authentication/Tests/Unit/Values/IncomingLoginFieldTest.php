<?php

namespace App\Containers\AppSection\Authentication\Tests\Unit\Values;

use App\Containers\AppSection\Authentication\DataTransferObjects\IncomingLoginField;
use App\Containers\AppSection\Authentication\Tests\UnitTestCase;
use PHPUnit\Framework\Attributes\CoversClass;

#[CoversClass(IncomingLoginField::class)]
final class IncomingLoginFieldTest extends UnitTestCase
{
    public function testCanCreateValue(): void
    {
        $value = new IncomingLoginField('email', 'gandalf@the.grey');

        $this->assertSame('email', $value->name);
        $this->assertSame('gandalf@the.grey', $value->value);
    }
}
