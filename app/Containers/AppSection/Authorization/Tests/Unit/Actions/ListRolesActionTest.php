<?php

namespace App\Containers\AppSection\Authorization\Tests\Unit\Actions;

use App\Containers\AppSection\Authorization\Actions\ListRolesAction;
use App\Containers\AppSection\Authorization\Models\Role;
use App\Containers\AppSection\Authorization\Tests\UnitTestCase;
use PHPUnit\Framework\Attributes\CoversClass;

#[CoversClass(ListRolesAction::class)]
final class ListRolesActionTest extends UnitTestCase
{
    public function testCanListRoles(): void
    {
        Role::factory()->count(2)->create();
        $action = app(ListRolesAction::class);

        $result = $action->run();

        $this->assertCount(4, $result);
    }
}
