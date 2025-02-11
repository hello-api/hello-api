<?php

namespace App\Containers\AppSection\Authentication\Tests\Unit\UI\API\Requests;

use App\Containers\AppSection\Authentication\Tests\UnitTestCase;
use App\Containers\AppSection\Authentication\UI\API\Requests\RefreshProxyRequest;
use PHPUnit\Framework\Attributes\CoversClass;

#[CoversClass(RefreshProxyRequest::class)]
final class RefreshProxyRequestTest extends UnitTestCase
{
    private RefreshProxyRequest $request;

    public function testDecode(): void
    {
        $this->assertSame([], $this->request->getDecodeArray());
    }

    public function testValidationRules(): void
    {
        $this->assertSame([
            'refresh_token' => 'string',
        ], $this->request->rules());
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->request = new RefreshProxyRequest();
    }
}
