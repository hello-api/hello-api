<?php

namespace App\Containers\AppSection\Authorization\Tests\Unit\Actions;

use App\Containers\AppSection\Authorization\Actions\FindPermissionByIdAction;
use App\Containers\AppSection\Authorization\Data\Repositories\PermissionRepository;
use App\Containers\AppSection\Authorization\Models\Permission;
use App\Containers\AppSection\Authorization\Tests\UnitTestCase;
use App\Containers\AppSection\Authorization\UI\API\Requests\FindPermissionByIdRequest;
use PHPUnit\Framework\Attributes\CoversClass;

#[CoversClass(FindPermissionByIdAction::class)]
final class FindPermissionByIdActionTest extends UnitTestCase
{
    public function testCanFindPermission(): void
    {
        $permission = Permission::factory()->createOne();
        $request = FindPermissionByIdRequest::injectData()->withUrlParameters(['permission_id' => $permission->id]);
        $repositoryMock = $this->partialMock(PermissionRepository::class);
        $repositoryMock->expects('getById')->once()->with($request->permission_id)->andReturn($permission);

        app(FindPermissionByIdAction::class)->run($request);
    }
}
