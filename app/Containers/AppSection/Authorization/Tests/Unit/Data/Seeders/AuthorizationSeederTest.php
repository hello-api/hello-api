<?php

namespace App\Containers\AppSection\Authorization\Tests\Unit\Data\Seeders;

use App\Containers\AppSection\Authorization\Data\Seeders\AuthorizationSeeder_1;
use App\Containers\AppSection\Authorization\Enums\Role;
use App\Containers\AppSection\Authorization\Tests\UnitTestCase;
use PHPUnit\Framework\Attributes\CoversClass;

#[CoversClass(AuthorizationSeeder_1::class)]
final class AuthorizationSeederTest extends UnitTestCase
{
    public function testCanSeed(): void
    {
        $this->assertDatabaseCount('roles', 2);
        foreach (config('auth.guards') as $name => $value) {
            $this->assertDatabaseHas('roles', [
                'name' => Role::SUPER_ADMIN,
                'guard_name' => $name,
            ]);
        }
    }
}
