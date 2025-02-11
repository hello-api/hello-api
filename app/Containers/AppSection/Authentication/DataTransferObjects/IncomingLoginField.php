<?php

namespace App\Containers\AppSection\Authentication\DataTransferObjects;

use Apiato\Http\Resources\HasResourceKey;
use Apiato\Http\Resources\ResourceKeyAware;

final class IncomingLoginField implements ResourceKeyAware
{
    use HasResourceKey;

    public function __construct(
        public readonly string $name,
        public readonly string $value,
    ) {
    }
}
