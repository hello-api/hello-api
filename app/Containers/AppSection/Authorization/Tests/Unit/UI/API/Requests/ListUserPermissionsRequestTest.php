<?php

namespace App\Containers\AppSection\Authorization\Tests\Unit\UI\API\Requests;

use App\Containers\AppSection\Authorization\Tests\UnitTestCase;
use App\Containers\AppSection\Authorization\UI\API\Requests\ListUserPermissionsRequest;
use PHPUnit\Framework\Attributes\CoversClass;

#[CoversClass(ListUserPermissionsRequest::class)]
final class ListUserPermissionsRequestTest extends UnitTestCase
{
    private ListUserPermissionsRequest $request;

    public function testDecode(): void
    {
        $this->assertSame([
            'user_id',
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
        $request = ListUserPermissionsRequest::injectData([], $user)->withUrlParameters(['user_id' => $user->id]);

        $this->assertFalse($request->authorize());
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->request = new ListUserPermissionsRequest();
    }
}
