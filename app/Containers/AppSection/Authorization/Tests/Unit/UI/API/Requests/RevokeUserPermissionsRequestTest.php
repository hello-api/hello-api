<?php

namespace App\Containers\AppSection\Authorization\Tests\Unit\UI\API\Requests;

use App\Containers\AppSection\Authorization\Tests\UnitTestCase;
use App\Containers\AppSection\Authorization\UI\API\Requests\RevokeUserPermissionsRequest;
use PHPUnit\Framework\Attributes\CoversClass;

#[CoversClass(RevokeUserPermissionsRequest::class)]
final class RevokeUserPermissionsRequestTest extends UnitTestCase
{
    private RevokeUserPermissionsRequest $request;

    public function testDecode(): void
    {
        $this->assertSame([
            'user_id',
            'permission_ids.*',
        ], $this->request->getDecodeArray());
    }

    public function testValidationRules(): void
    {
        $rules = $this->request->rules();

        $this->assertSame([
            'user_id' => 'exists:users,id',
            'permission_ids' => 'array|required',
            'permission_ids.*' => 'exists:permissions,id',
        ], $rules);
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->request = new RevokeUserPermissionsRequest();
    }
}
