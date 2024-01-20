<?php

namespace App\Containers\AppSection\Authorization\Tests\Unit\Tasks;

use App\Containers\AppSection\Authorization\Tasks\CreateRoleTask;
use App\Containers\AppSection\Authorization\Tests\UnitTestCase;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Group;

#[Group('authorization')]
#[CoversClass(CreateRoleTask::class)]
final class CreateRoleTaskTest extends UnitTestCase
{
    public function testCreateRole(): void
    {
        $name = 'MEga_AdmIn';
        $description = 'The One above all';
        $display_name = 'Mega Admin the Almighty';

        $role = app(CreateRoleTask::class)->run($name, $description, $display_name);

        $this->assertSame(strtolower($name), $role->name);
        $this->assertSame($description, $role->description);
        $this->assertSame($display_name, $role->display_name);
        $this->assertSame('api', $role->guard_name);
    }
}