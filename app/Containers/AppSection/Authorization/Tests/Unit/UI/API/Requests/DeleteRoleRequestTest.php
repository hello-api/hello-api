<?php

namespace App\Containers\AppSection\Authorization\Tests\Unit\UI\API\Requests;

use App\Containers\AppSection\Authorization\Models\Role;
use App\Containers\AppSection\Authorization\Tests\UnitTestCase;
use App\Containers\AppSection\Authorization\UI\API\Requests\DeleteRoleRequest;
use PHPUnit\Framework\Attributes\CoversClass;

#[CoversClass(DeleteRoleRequest::class)]
final class DeleteRoleRequestTest extends UnitTestCase
{
    private DeleteRoleRequest $request;

    public function testDecode(): void
    {
        $this->assertSame([
            'role_id',
        ], $this->request->getDecodeArray());
    }

    public function testValidationRules(): void
    {
        $rules = $this->request->rules();

        $this->assertSame([], $rules);
    }

    public function testAuthorizeMethodGateCall(): void
    {
        $user = $this->getTestingUserWithoutAccess();
        $request = DeleteRoleRequest::injectData([], $user)->withUrlParameters(['role_id' => Role::factory()->createOne()->id]);

        $this->assertFalse($request->authorize());
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->request = new DeleteRoleRequest();
    }
}
