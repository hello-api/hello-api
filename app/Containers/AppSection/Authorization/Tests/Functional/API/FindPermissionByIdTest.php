<?php

namespace App\Containers\AppSection\Authorization\Tests\Functional\API;

use App\Containers\AppSection\Authorization\Models\Permission;
use App\Containers\AppSection\Authorization\Tests\Functional\ApiTestCase;
use PHPUnit\Framework\Attributes\CoversNothing;

#[CoversNothing]
final class FindPermissionByIdTest extends ApiTestCase
{
    protected string $endpoint = 'get@v1/permissions/{permission_id}';

    protected array $access = [
        'permissions' => 'manage-permissions',
        'roles' => null,
    ];

    public function testFindPermissionById(): void
    {
        $permissionA = Permission::factory()->createOne();

        $response = $this->injectId($permissionA->id, replace: '{permission_id}')->makeCall();

        $response->assertOk();
        $responseContent = $this->getResponseContentObject();
        $this->assertSame($permissionA->name, $responseContent->data->name);
    }

    public function testFindNonExistingPermission(): void
    {
        $invalidId = 7777777;

        $response = $this->injectId($invalidId, replace: '{permission_id}')->makeCall();

        $response->assertNotFound();
    }
}
