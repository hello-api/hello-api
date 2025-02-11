<?php

namespace App\Ship\Tests\Unit\Commands;

use App\Ship\Commands\HelloWorld;
use App\Ship\Tests\ShipTestCase;
use PHPUnit\Framework\Attributes\CoversClass;

#[CoversClass(HelloWorld::class)]
final class HelloWorldTest extends ShipTestCase
{
    public function testCommand(): void
    {
        $this->artisan('hello:world')
            ->expectsOutput('Hello World!')
            ->assertSuccessful();
    }
}
