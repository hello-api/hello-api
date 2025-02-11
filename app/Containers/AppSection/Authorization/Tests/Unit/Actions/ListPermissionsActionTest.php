<?php

namespace App\Containers\AppSection\Authorization\Tests\Unit\Actions;

use App\Containers\AppSection\Authorization\Actions\ListPermissionsAction;
use App\Containers\AppSection\Authorization\Models\Permission;
use App\Containers\AppSection\Authorization\Tests\UnitTestCase;
use PHPUnit\Framework\Attributes\CoversClass;

#[CoversClass(ListPermissionsAction::class)]
final class ListPermissionsActionTest extends UnitTestCase
{
    public function testCanListPermissions(): void
    {
        Permission::factory()->count(3)->create();
        $action = app(ListPermissionsAction::class);

        $result = $action->run();

        $this->assertCount(3, $result);
    }
}
