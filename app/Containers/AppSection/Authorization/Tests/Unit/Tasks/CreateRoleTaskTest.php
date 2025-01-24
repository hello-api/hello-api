<?php

namespace App\Containers\AppSection\Authorization\Tests\Unit\Tasks;

use App\Containers\AppSection\Authorization\Data\Repositories\RoleRepository;
use App\Containers\AppSection\Authorization\Tasks\CreateRoleTask;
use App\Containers\AppSection\Authorization\Tests\UnitTestCase;
use App\Ship\Exceptions\CreateResourceFailed;
use PHPUnit\Framework\Attributes\CoversClass;

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

    public function testCatchesAllExceptionsAndThrowsCustomException(): void
    {
        $this->expectException(CreateResourceFailed::class);

        $name = 'MEga_AdmIn';
        $description = 'The One above all';
        $display_name = 'Mega Admin the Almighty';
        $this->partialMock(RoleRepository::class)
            ->expects('create')->andThrowExceptions([
                new \Exception(),
            ]);

        app(CreateRoleTask::class)->run($name, $description, $display_name);
    }
}
