<?php

namespace App\Containers\AppSection\Authentication\Tests\Unit\UI\API\Requests;

use App\Containers\AppSection\Authentication\Tests\UnitTestCase;
use App\Containers\AppSection\Authentication\UI\API\Requests\VerifyEmailRequest;
use PHPUnit\Framework\Attributes\CoversClass;

#[CoversClass(VerifyEmailRequest::class)]
final class VerifyEmailRequestTest extends UnitTestCase
{
    private VerifyEmailRequest $request;

    public function testDecode(): void
    {
        $this->assertSame([
            'user_id',
        ], $this->request->getDecodeArray());
    }

    public function testValidationRules(): void
    {
        $this->assertSame([], $this->request->rules());
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->request = new VerifyEmailRequest();
    }
}
