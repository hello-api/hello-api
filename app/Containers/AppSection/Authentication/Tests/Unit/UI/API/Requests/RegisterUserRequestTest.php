<?php

namespace App\Containers\AppSection\Authentication\Tests\Unit\UI\API\Requests;

use App\Containers\AppSection\Authentication\Tests\UnitTestCase;
use App\Containers\AppSection\Authentication\UI\API\Requests\RegisterUserRequest;
use App\Containers\AppSection\User\Enums\Gender;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use PHPUnit\Framework\Attributes\CoversClass;

#[CoversClass(RegisterUserRequest::class)]
final class RegisterUserRequestTest extends UnitTestCase
{
    private RegisterUserRequest $request;

    public function testDecode(): void
    {
        $this->assertSame([], $this->request->getDecodeArray());
    }

    public function testValidationRules(): void
    {
        $this->assertEquals([
            'email' => 'required|email|unique:users,email',
            'password' => [
                'required',
                Password::default(),
            ],
            'name' => 'min:2|max:50',
            'gender' => Rule::enum(Gender::class),
            'birth' => 'date',
            'verification_url' => [
                'url',
                Rule::requiredIf(static fn (): bool => config('appSection-authentication.require_email_verification')),
                Rule::in(config('appSection-authentication.allowed-verify-email-urls')),
            ],
        ], $this->request->rules());
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->request = new RegisterUserRequest();
    }
}
