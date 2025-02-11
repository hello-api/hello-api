<?php

namespace App\Containers\AppSection\Authentication\Tests\Unit\UI\API\Requests;

use App\Containers\AppSection\Authentication\Tests\UnitTestCase;
use App\Containers\AppSection\Authentication\UI\API\Requests\SendVerificationEmailRequest;
use Illuminate\Validation\Rule;
use PHPUnit\Framework\Attributes\CoversClass;

#[CoversClass(SendVerificationEmailRequest::class)]
final class SendVerificationEmailRequestTest extends UnitTestCase
{
    private SendVerificationEmailRequest $request;

    public function testDecode(): void
    {
        $this->assertSame([], $this->request->getDecodeArray());
    }

    public function testValidationRules(): void
    {
        $this->assertEquals([
            'verification_url' => [
                'required',
                'url',
                Rule::in(config('appSection-authentication.allowed-verify-email-urls')),
            ],
        ], $this->request->rules());
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->request = new SendVerificationEmailRequest();
    }
}
