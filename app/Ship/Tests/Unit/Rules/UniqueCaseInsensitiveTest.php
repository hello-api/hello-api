<?php

namespace App\Ship\Tests\Unit\Rules;

use App\Containers\AppSection\User\Data\Factories\UserFactory;
use App\Ship\Rules\UniqueCaseInsensitive;
use App\Ship\Tests\ShipTestCase;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Group;

#[Group('ship')]
#[CoversClass(UniqueCaseInsensitive::class)]
final class UniqueCaseInsensitiveTest extends ShipTestCase
{
    public function testAttributeIsUnique(): void
    {
        $rule = new UniqueCaseInsensitive('users', 'email');
        $fail = function ($message) {
            $this->fail($message);
        };

        $rule->validate('email', 'unique@example.com', $fail);

        $this->assertTrue(true);
    }

    public function testAttributeIsNotUnique(): void
    {
        UserFactory::new()->createOne(['email' => 'duplicate@example.com']);

        $rule = new UniqueCaseInsensitive('users', 'email');
        $fail = function ($message) {
            $this->assertEquals('The :attribute has already been taken.', $message);
        };

        $rule->validate('email', 'duplicate@example.com', $fail);
    }

    public function testAttributeIsUniqueWithDifferentCase(): void
    {
        $rule = new UniqueCaseInsensitive('users', 'email');
        $fail = function ($message) {
            $this->fail($message);
        };

        $rule->validate('email', 'Unique@Example.com', $fail);

        $this->assertTrue(true);
    }

    public function testAttributeIsNotUniqueWithDifferentCase(): void
    {
        UserFactory::new()->createOne(['email' => 'duplicate@example.com']);

        $rule = new UniqueCaseInsensitive('users', 'email');
        $fail = function ($message) {
            $this->assertEquals('The :attribute has already been taken.', $message);
        };

        $rule->validate('email', 'Duplicate@Example.com', $fail);
    }
}
