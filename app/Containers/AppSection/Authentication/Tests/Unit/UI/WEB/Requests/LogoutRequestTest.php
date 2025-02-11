<?php

namespace App\Containers\AppSection\Authentication\Tests\Unit\UI\WEB\Requests;

use App\Containers\AppSection\Authentication\Tests\UnitTestCase;
use App\Containers\AppSection\Authentication\UI\WEB\Requests\LogoutRequest;
use PHPUnit\Framework\Attributes\CoversClass;

#[CoversClass(LogoutRequest::class)]
final class LogoutRequestTest extends UnitTestCase
{
    private LogoutRequest $request;

    public function testDecode(): void
    {
        $this->assertSame([], $this->request->getDecodeArray());
    }

    public function testValidationRules(): void
    {
        $rules = $this->request->rules();

        $this->assertSame([], $rules);
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->request = new LogoutRequest();
    }
}
