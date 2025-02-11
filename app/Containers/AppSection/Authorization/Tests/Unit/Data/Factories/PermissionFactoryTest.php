<?php

namespace App\Containers\AppSection\Authorization\Tests\Unit\Data\Factories;

use App\Containers\AppSection\Authorization\Data\Factories\PermissionFactory;
use App\Containers\AppSection\Authorization\Models\Permission;
use App\Containers\AppSection\Authorization\Tests\UnitTestCase;
use App\Ship\Enums\AuthGuard;
use PHPUnit\Framework\Attributes\CoversClass;

#[CoversClass(PermissionFactory::class)]
final class PermissionFactoryTest extends UnitTestCase
{
    public function testCanCreatePermission(): void
    {
        $permission = Permission::factory()->createOne();

        $this->assertInstanceOf(Permission::class, $permission);
    }

    public function testCanSetGuard(): void
    {
        $permission = Permission::factory()->withGuard(AuthGuard::API->value)->createOne();

        $this->assertSame(AuthGuard::API->value, $permission->guard_name);
    }
}
