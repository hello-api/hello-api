<?php

namespace App\Containers\AppSection\User\Tests\Unit\UI\API\Requests;

use App\Containers\AppSection\User\Enums\Gender;
use App\Containers\AppSection\User\Models\User;
use App\Containers\AppSection\User\Tests\UnitTestCase;
use App\Containers\AppSection\User\UI\API\Requests\UpdateUserRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use PHPUnit\Framework\Attributes\CoversClass;

#[CoversClass(UpdateUserRequest::class)]
final class UpdateUserRequestTest extends UnitTestCase
{
    private UpdateUserRequest $request;

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
            'name' => 'min:2|max:50',
            'gender' => [Rule::enum(Gender::class), 'nullable'],
            'birth' => ['date', 'nullable'],
            'current_password' => [
                Rule::requiredIf(fn (): bool => !is_null($this->request->user()->password) && $this->request->filled('new_password')),
                'current_password:api',
            ],
            'new_password' => [
                Password::default(),
                'required_with:current_password',
            ],
            'new_password_confirmation' => 'required_with:new_password|same:new_password',
        ], $rules);
    }

    public function testAuthorizeMethodGateCall(): void
    {
        $user = User::factory()->createOne();
        $request = UpdateUserRequest::injectData([], $user)
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

        $this->request = new UpdateUserRequest();
    }
}
