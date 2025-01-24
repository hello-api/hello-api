<?php

namespace App\Containers\AppSection\Authorization\Tests\Unit\Models;

use Apiato\Foundation\Support\Traits\Model\ModelTrait;
use App\Containers\AppSection\Authorization\Models\Role;
use App\Containers\AppSection\Authorization\Tests\UnitTestCase;
use PHPUnit\Framework\Attributes\CoversClass;

#[CoversClass(Role::class)]
final class RoleTest extends UnitTestCase
{
    public function testUsesCorrectTraits(): void
    {
        $this->assertContains(ModelTrait::class, class_uses_recursive(Role::class));
    }

    public function testHasCorrectFillableFields(): void
    {
        $role = Role::factory()->createOne();
        $fillables = [
            'name',
            'guard_name',
            'display_name',
            'description',
        ];

        foreach ($fillables as $fillable) {
            $this->assertContains($fillable, $role->getFillable());
        }
    }

    public function testUsesCorrectTable(): void
    {
        $role = Role::factory()->createOne();
        $table = 'roles';

        $this->assertSame($table, $role->getTable());
    }

    public function testHasCorrectResourceKey(): void
    {
        $role = Role::factory()->createOne();

        $this->assertSame('Role', $role->getResourceKey());
    }
}
