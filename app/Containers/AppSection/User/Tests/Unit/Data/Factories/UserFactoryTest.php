<?php

namespace App\Containers\AppSection\User\Tests\Unit\Data\Factories;

use App\Containers\AppSection\User\Data\Factories\UserFactory;
use App\Containers\AppSection\User\Enums\Gender;
use App\Containers\AppSection\User\Models\User;
use App\Containers\AppSection\User\Tests\UnitTestCase;
use PHPUnit\Framework\Attributes\CoversClass;

#[CoversClass(UserFactory::class)]
final class UserFactoryTest extends UnitTestCase
{
    public function testCanCreateUser(): void
    {
        $user = User::factory()->createOne();

        $this->assertInstanceOf(User::class, $user);
    }

    public function testCanCreateAdminUser(): void
    {
        $user = User::factory()->admin()->createOne();

        $this->assertTrue($user->hasRole(config('appSection-authorization.admin_role')));
    }

    public function testCanCreateUnverifiedUser(): void
    {
        $user = User::factory()->unverified()->createOne();

        $this->assertNull($user->email_verified_at);
    }

    public function testCanSetGender(): void
    {
        $user = User::factory()->gender(Gender::MALE)->createOne();

        $this->assertSame(Gender::MALE, $user->gender);
    }
}
