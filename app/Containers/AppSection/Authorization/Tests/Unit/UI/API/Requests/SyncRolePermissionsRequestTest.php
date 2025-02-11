<?php

namespace App\Containers\AppSection\Authorization\Tests\Unit\UI\API\Requests;

use App\Containers\AppSection\Authorization\Tests\UnitTestCase;
use App\Containers\AppSection\Authorization\UI\API\Requests\SyncRolePermissionsRequest;
use PHPUnit\Framework\Attributes\CoversClass;

#[CoversClass(SyncRolePermissionsRequest::class)]
final class SyncRolePermissionsRequestTest extends UnitTestCase
{
    private SyncRolePermissionsRequest $request;

    public function testDecode(): void
    {
        $this->assertSame([
            'role_id',
            'permission_ids.*',
        ], $this->request->getDecodeArray());
    }

    public function testValidationRules(): void
    {
        $rules = $this->request->rules();

        $this->assertSame([
            'role_id' => 'exists:roles,id',
            'permission_ids' => 'array|required',
            'permission_ids.*' => 'required|exists:permissions,id',
        ], $rules);
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->request = new SyncRolePermissionsRequest();
    }
}
