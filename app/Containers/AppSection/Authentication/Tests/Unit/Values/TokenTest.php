<?php

namespace App\Containers\AppSection\Authentication\Tests\Unit\Values;

use App\Containers\AppSection\Authentication\DataTransferObjects\Token;
use App\Containers\AppSection\Authentication\Tests\UnitTestCase;
use PHPUnit\Framework\Attributes\CoversClass;

#[CoversClass(Token::class)]
final class TokenTest extends UnitTestCase
{
    public function testCanCreateValue(): void
    {
        $value = new Token(fake()->word(), fake()->numberBetween(), fake()->sha256(), fake()->sha256());

        $this->assertSame('string', gettype($value->tokenType));
        $this->assertSame('integer', gettype($value->expiresIn));
        $this->assertSame('string', gettype($value->accessToken));
        $this->assertSame('string', gettype($value->refreshToken));
    }

    public function testCanCreateFakeValue(): void
    {
        $value = Token::fake();

        $this->assertSame('string', gettype($value->tokenType));
        $this->assertSame('integer', gettype($value->expiresIn));
        $this->assertSame('string', gettype($value->accessToken));
        $this->assertSame('string', gettype($value->refreshToken));
    }
}
