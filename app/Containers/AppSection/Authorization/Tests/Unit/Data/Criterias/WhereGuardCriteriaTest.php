<?php

namespace App\Containers\AppSection\Authorization\Tests\Unit\Data\Criterias;

use App\Containers\AppSection\Authorization\Data\Criterias\WhereGuardCriteria;
use App\Containers\AppSection\Authorization\Data\Repositories\PermissionRepository;
use App\Containers\AppSection\Authorization\Data\Repositories\RoleRepository;
use App\Containers\AppSection\Authorization\Models\Permission;
use App\Containers\AppSection\Authorization\Models\Role;
use App\Containers\AppSection\Authorization\Tests\UnitTestCase;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;

#[CoversClass(WhereGuardCriteria::class)]
final class WhereGuardCriteriaTest extends UnitTestCase
{
    #[DataProvider('authGuardDataProvider')]
    public function testWorksWithRoleModel(string $guard): void
    {
        Role::factory()->withGuard($guard)->count(2)->create();
        Role::factory()->withGuard(fake()->word())->createOne();
        $repository = app(RoleRepository::class);
        $criteria = app(WhereGuardCriteria::class, compact('guard'));
        $repository->pushCriteria($criteria);

        $result = $repository->all();

        $this->assertCount(3, $result);
        $this->assertEquals($guard, $result->first()->guard_name);
        $this->assertEquals($guard, $result->last()->guard_name);
    }

    #[DataProvider('authGuardDataProvider')]
    public function testWorksWithPermissionModel(string $guard): void
    {
        Permission::factory()->withGuard($guard)->count(2)->create();
        Permission::factory()->withGuard(fake()->word())->createOne();
        $repository = app(PermissionRepository::class);
        $criteria = app(WhereGuardCriteria::class, compact('guard'));
        $repository->pushCriteria($criteria);

        $result = $repository->all();

        $this->assertCount(7, $result);
        $this->assertEquals($guard, $result->first()->guard_name);
        $this->assertEquals($guard, $result->last()->guard_name);
    }
}
