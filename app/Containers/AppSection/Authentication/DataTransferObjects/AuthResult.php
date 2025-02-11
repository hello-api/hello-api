<?php

namespace App\Containers\AppSection\Authentication\DataTransferObjects;

use Apiato\Http\Resources\HasResourceKey;
use Apiato\Http\Resources\ResourceKeyAware;
use Symfony\Component\HttpFoundation\Cookie;

final class AuthResult implements ResourceKeyAware
{
    use HasResourceKey;

    public function __construct(
        public readonly Token $token,
        public readonly Cookie $refreshTokenCookie,
    ) {
    }

    public static function fake(): self
    {
        return new self(
            Token::fake(),
            new Cookie(
                'refreshToken',
                fake()->sha256(),
            ),
        );
    }
}
