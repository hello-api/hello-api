<?php

namespace App\Containers\AppSection\Authentication\DataTransferObjects;

use Apiato\Http\Resources\HasResourceKey;
use Apiato\Http\Resources\ResourceKeyAware;

final class LoginField implements \Stringable, ResourceKeyAware
{
    use HasResourceKey;

    public function __construct(
        private readonly string $name,
        private readonly array $rules,
    ) {
    }

    public function __toString(): string
    {
        return $this->name;
    }

    public function toArray(): array
    {
        return [$this->name => $this->rules];
    }

    public function rules(): array
    {
        return $this->rules;
    }

    public function name(): string
    {
        return $this->name;
    }
}
