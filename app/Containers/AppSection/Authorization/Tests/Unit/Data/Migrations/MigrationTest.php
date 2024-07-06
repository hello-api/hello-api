<?php

namespace App\Containers\AppSection\Authorization\Tests\Unit\Data\Migrations;

use App\Containers\AppSection\Authorization\Tests\UnitTestCase;
use PHPUnit\Framework\Attributes\CoversNothing;
use PHPUnit\Framework\Attributes\Group;

#[Group('authorization')]
#[CoversNothing]
final class MigrationTest extends UnitTestCase
{
    private array $tableNames;
    private array $columnNames;

    protected function setUp(): void
    {
        parent::setUp();
        $this->tableNames = config('permission.table_names');
        $this->columnNames = config('permission.column_names');
    }

    public function testPermissionsTableHasExpectedColumns(): void
    {
        $columns = [
            'id' => 'bigint',
            'name' => 'varchar',
            'guard_name' => 'varchar',
            'display_name' => 'varchar',
            'description' => 'varchar',
            'created_at' => 'timestamp',
            'updated_at' => 'timestamp',
        ];

        $this->assertDatabaseTable($this->tableNames['permissions'], $columns);
    }

    public function testRolesTableHasExpectedColumns(): void
    {
        $columns = [
            'id' => 'bigint',
            'name' => 'varchar',
            'guard_name' => 'varchar',
            'display_name' => 'varchar',
            'description' => 'varchar',
            'created_at' => 'timestamp',
            'updated_at' => 'timestamp',
        ];

        $this->assertDatabaseTable($this->tableNames['roles'], $columns);
    }

    public function testModelHasPermissionsTableHasExpectedColumns(): void
    {
        $columns = [
            'permission_id' => 'bigint',
            'model_type' => 'varchar',
            $this->columnNames['model_morph_key'] => 'bigint',
        ];

        $this->assertDatabaseTable($this->tableNames['model_has_permissions'], $columns);
    }

    public function testModelHasRolesTableHasExpectedColumns(): void
    {
        $columns = [
            'role_id' => 'bigint',
            'model_type' => 'varchar',
            $this->columnNames['model_morph_key'] => 'bigint',
        ];

        $this->assertDatabaseTable($this->tableNames['model_has_roles'], $columns);
    }

    public function testRoleHasPermissionsTableHasExpectedColumns(): void
    {
        $columns = [
            'permission_id' => 'bigint',
            'role_id' => 'bigint',
        ];

        $this->assertDatabaseTable($this->tableNames['role_has_permissions'], $columns);
    }
}
