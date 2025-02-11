<?php

namespace App\Containers\AppSection\Authentication\DataTransferObjects;

use Apiato\Http\Resources\HasResourceKey;
use Apiato\Http\Resources\ResourceKeyAware;

final class Token implements ResourceKeyAware
{
    use HasResourceKey;

    public function __construct(
        public readonly string $tokenType,
        public readonly int $expiresIn,
        public readonly string $accessToken,
        public readonly string $refreshToken,
    ) {
    }

    public static function fake(): self
    {
        return new self(
            fake()->word(),
            fake()->numberBetween(),
            fake()->sha256(),
            fake()->sha256(),
        );
    }
}
