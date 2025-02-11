<?php

namespace App\Containers\AppSection\Authentication\Tests\Unit\Values;

use App\Containers\AppSection\Authentication\DataTransferObjects\AuthResult;
use App\Containers\AppSection\Authentication\DataTransferObjects\Token;
use App\Containers\AppSection\Authentication\Tests\UnitTestCase;
use PHPUnit\Framework\Attributes\CoversClass;
use Symfony\Component\HttpFoundation\Cookie;

#[CoversClass(AuthResult::class)]
final class AuthResultTest extends UnitTestCase
{
    public function testCanCreateValue(): void
    {
        $value = new AuthResult(
            Token::fake(),
            new Cookie(
                'refreshToken',
                fake()->sha256(),
            ),
        );

        $this->assertInstanceOf(Token::class, $value->token);
        $this->assertInstanceOf(Cookie::class, $value->refreshTokenCookie);
    }

    public function testCanCreateFakeValue(): void
    {
        $value = AuthResult::fake();

        $this->assertInstanceOf(Token::class, $value->token);
        $this->assertInstanceOf(Cookie::class, $value->refreshTokenCookie);
    }
}
