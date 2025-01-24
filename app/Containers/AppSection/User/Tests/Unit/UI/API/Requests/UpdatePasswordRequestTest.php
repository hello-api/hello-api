<?php

namespace App\Containers\AppSection\User\Tests\Unit\UI\API\Requests;

use App\Containers\AppSection\User\Models\User;
use App\Containers\AppSection\User\Tests\UnitTestCase;
use App\Containers\AppSection\User\UI\API\Requests\UpdatePasswordRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use PHPUnit\Framework\Attributes\CoversClass;

#[CoversClass(UpdatePasswordRequest::class)]
final class UpdatePasswordRequestTest extends UnitTestCase
{
    private UpdatePasswordRequest $request;

    public function testDecode(): void
    {
        $this->assertSame([
            'user_id',
        ], $this->request->getDecodeArray());
    }

    public function testUrlParametersArray(): void
    {
        $this->assertSame([
            'user_id',
        ], $this->request->getUrlParametersArray());
    }

    public function testValidationRules(): void
    {
        $rules = $this->request->rules();

        $this->assertEquals([
            'current_password' => [
                Rule::requiredIf(fn (): bool => !is_null($this->request->user()->password)),
                'current_password:api',
            ],
            'new_password' => [
                'required',
                Password::default(),
            ],
            'new_password_confirmation' => 'required_with:new_password|same:new_password',
        ], $rules);
    }

    public function testAuthorizeMethodGateCall(): void
    {
        $user = User::factory()->createOne();
        $request = UpdatePasswordRequest::injectData([], $user)
            ->withUrlParameters([
                'user_id' => $user->id,
            ]);
        $gateMock = $this->getGateMock('update', [
            User::class,
            $user->id,
        ]);

        $this->assertTrue($request->authorize($gateMock));
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->request = new UpdatePasswordRequest();
    }
}
