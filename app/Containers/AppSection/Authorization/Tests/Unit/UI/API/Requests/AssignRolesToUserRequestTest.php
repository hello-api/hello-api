<?php

namespace App\Containers\AppSection\Authorization\Tests\Unit\UI\API\Requests;

use App\Containers\AppSection\Authorization\Tests\UnitTestCase;
use App\Containers\AppSection\Authorization\UI\API\Requests\AssignRolesToUserRequest;
use PHPUnit\Framework\Attributes\CoversClass;

#[CoversClass(AssignRolesToUserRequest::class)]
final class AssignRolesToUserRequestTest extends UnitTestCase
{
    private AssignRolesToUserRequest $request;

    public function testDecode(): void
    {
        $this->assertSame([
            'user_id',
            'role_ids.*',
        ], $this->request->getDecodeArray());
    }

    public function testValidationRules(): void
    {
        $rules = $this->request->rules();

        $this->assertSame([
            'user_id' => 'exists:users,id',
            'role_ids' => 'array|required',
            'role_ids.*' => 'exists:roles,id',
        ], $rules);
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->request = new AssignRolesToUserRequest();
    }
}
