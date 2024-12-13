<?php

namespace App\Containers\AppSection\User\Values;

use App\Ship\Parents\Values\Value as ParentValue;
use App\Ship\Rules\UniqueCaseInsensitive;
use Illuminate\Contracts\Database\Eloquent\Castable;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;

// TODO: This is a BREAKING CHANGE. Users must update their email getters to use the `value` property.
//  Example: $user->email->value
class Email extends ParentValue implements \Stringable, Castable, \JsonSerializable
{
    public function __construct(
        public readonly string $value,
    ) {
    }

    public static function castUsing(array $arguments): CastsAttributes
    {
        return new class implements CastsAttributes {
            public function get($model, string $key, $value, array $attributes): Email
            {
                return new Email(strtolower($value));
            }

            public function set($model, string $key, $value, array $attributes): array
            {
                return [$key => (string) $value];
            }
        };
    }

    public function validate(): void
    {
        tap(validator(['email' => $this->value], ['email' => static::rules()]))->validate();
    }

    public static function rules(): array
    {
        return [
            'email',
            new UniqueCaseInsensitive('users', 'email'),
        ];
    }

    public function __toString(): string
    {
        return $this->value;
    }

    public function equals(self $email): bool
    {
        return $this->value === $email->value;
    }

    public function jsonSerialize(): string
    {
        return $this->value;
    }
}
