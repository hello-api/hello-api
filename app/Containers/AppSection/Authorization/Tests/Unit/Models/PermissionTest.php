<?php

namespace App\Containers\AppSection\Authorization\Tests\Unit\Models;

use Apiato\Foundation\Support\Traits\Model\ModelTrait;
use App\Containers\AppSection\Authorization\Models\Permission;
use App\Containers\AppSection\Authorization\Tests\UnitTestCase;
use PHPUnit\Framework\Attributes\CoversClass;

#[CoversClass(Permission::class)]
final class PermissionTest extends UnitTestCase
{
    public function testUsesCorrectTraits(): void
    {
        $this->assertContains(ModelTrait::class, class_uses_recursive(Permission::class));
    }

    public function testHasCorrectFillableFields(): void
    {
        $permission = Permission::factory()->createOne();
        $fillables = [
            'name',
            'guard_name',
            'display_name',
            'description',
        ];

        foreach ($fillables as $fillable) {
            $this->assertContains($fillable, $permission->getFillable());
        }
    }

    public function testUsesCorrectTable(): void
    {
        $permission = Permission::factory()->createOne();
        $table = 'permissions';

        $this->assertSame($table, $permission->getTable());
    }

    public function testHasCorrectResourceKey(): void
    {
        $permission = Permission::factory()->createOne();

        $this->assertSame('Permission', $permission->getResourceKey());
    }
}
