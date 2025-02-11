<?php

namespace App\Containers\AppSection\Authentication\Tests\Unit\UI\API\Requests;

use App\Containers\AppSection\Authentication\Classes\LoginFieldParser;
use App\Containers\AppSection\Authentication\Tests\UnitTestCase;
use App\Containers\AppSection\Authentication\UI\API\Requests\LoginProxyPasswordGrantRequest;
use PHPUnit\Framework\Attributes\CoversClass;

#[CoversClass(LoginProxyPasswordGrantRequest::class)]
final class LoginProxyPasswordGrantRequestTest extends UnitTestCase
{
    private LoginProxyPasswordGrantRequest $request;

    public function testDecode(): void
    {
        $this->assertSame([], $this->request->getDecodeArray());
    }

    public function testValidationRules(): void
    {
        $this->assertEquals(
            LoginFieldParser::mergeValidationRules(['password' => 'required']),
            $this->request->rules(),
        );
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->request = new LoginProxyPasswordGrantRequest();
    }
}
