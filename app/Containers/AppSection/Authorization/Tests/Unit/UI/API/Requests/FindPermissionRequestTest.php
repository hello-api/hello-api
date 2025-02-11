<?php

namespace App\Containers\AppSection\Authorization\Tests\Unit\UI\API\Requests;

use App\Containers\AppSection\Authorization\Tests\UnitTestCase;
use App\Containers\AppSection\Authorization\UI\API\Requests\FindPermissionByIdRequest;
use PHPUnit\Framework\Attributes\CoversClass;

#[CoversClass(FindPermissionByIdRequest::class)]
final class FindPermissionRequestTest extends UnitTestCase
{
    private FindPermissionByIdRequest $request;

    public function testDecode(): void
    {
        $this->assertSame([
            'permission_id',
        ], $this->request->getDecodeArray());
    }

    public function testValidationRules(): void
    {
        $rules = $this->request->rules();

        $this->assertSame([], $rules);
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->request = new FindPermissionByIdRequest();
    }
}
