<?php

namespace App\Containers\AppSection\User\Tests\Unit\UI\API\Requests;

use App\Containers\AppSection\User\Tests\UnitTestCase;
use App\Containers\AppSection\User\UI\API\Requests\DeleteUserRequest;
use PHPUnit\Framework\Attributes\CoversClass;

#[CoversClass(DeleteUserRequest::class)]
final class DeleteUserRequestTest extends UnitTestCase
{
    private DeleteUserRequest $request;

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

    protected function setUp(): void
    {
        parent::setUp();

        $this->request = new DeleteUserRequest();
    }
}
