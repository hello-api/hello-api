<?php

namespace App\Containers\AppSection\Authorization\Tests\Unit\Data\Factories;

use App\Containers\AppSection\Authorization\Data\Factories\RoleFactory;
use App\Containers\AppSection\Authorization\Enums\Role as RoleEnum;
use App\Containers\AppSection\Authorization\Models\Role;
use App\Containers\AppSection\Authorization\Tests\UnitTestCase;
use App\Ship\Enums\AuthGuard;
use PHPUnit\Framework\Attributes\CoversClass;

#[CoversClass(RoleFactory::class)]
final class RoleFactoryTest extends UnitTestCase
{
    public function testCanCreateRole(): void
    {
        $role = Role::factory()->createOne();

        $this->assertInstanceOf(Role::class, $role);
    }

    public function testCanCreateAdminRole(): void
    {
        // Since 'admin' is seeded in the database, we need to delete it first
        // to avoid "duplicate key" error.
        $adminRole = Role::findByName(RoleEnum::SUPER_ADMIN->value);
        $adminRole->delete();
        $this->assertModelMissing($adminRole);

        $role = Role::factory()->admin()->createOne();

        $this->assertSame(RoleEnum::SUPER_ADMIN->value, $role->name);
    }

    public function testCanSetGuard(): void
    {
        $role = Role::factory()->withGuard(AuthGuard::API->value)->createOne();

        $this->assertSame(AuthGuard::API->value, $role->guard_name);
    }
}
