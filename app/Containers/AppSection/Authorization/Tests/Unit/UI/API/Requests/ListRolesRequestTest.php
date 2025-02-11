<?php

namespace App\Containers\AppSection\Authorization\Tests\Unit\UI\API\Requests;

use App\Containers\AppSection\Authorization\Tests\UnitTestCase;
use App\Containers\AppSection\Authorization\UI\API\Requests\ListRolesRequest;
use PHPUnit\Framework\Attributes\CoversClass;

#[CoversClass(ListRolesRequest::class)]
final class ListRolesRequestTest extends UnitTestCase
{
    private ListRolesRequest $request;

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

        $this->request = new ListRolesRequest();
    }
}
