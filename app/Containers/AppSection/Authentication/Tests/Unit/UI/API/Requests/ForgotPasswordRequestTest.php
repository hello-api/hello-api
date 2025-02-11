<?php

namespace App\Containers\AppSection\Authentication\Tests\Unit\UI\API\Requests;

use App\Containers\AppSection\Authentication\Tests\UnitTestCase;
use App\Containers\AppSection\Authentication\UI\API\Requests\ForgotPasswordRequest;
use Illuminate\Validation\Rule;
use PHPUnit\Framework\Attributes\CoversClass;

#[CoversClass(ForgotPasswordRequest::class)]
final class ForgotPasswordRequestTest extends UnitTestCase
{
    private ForgotPasswordRequest $request;

    public function testDecode(): void
    {
        $this->assertSame([], $this->request->getDecodeArray());
    }

    public function testValidationRules(): void
    {
        $this->assertEquals([
            'email' => 'required|email',
            'reseturl' => [
                'required',
                Rule::in(config('appSection-authentication.allowed-reset-password-urls')),
            ],
        ], $this->request->rules());
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->request = new ForgotPasswordRequest();
    }
}
