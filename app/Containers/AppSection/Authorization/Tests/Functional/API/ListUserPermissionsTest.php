<?php

namespace App\Containers\AppSection\Authorization\Tests\Functional\API;

use App\Containers\AppSection\Authorization\Models\Permission;
use App\Containers\AppSection\Authorization\Tests\Functional\ApiTestCase;
use App\Containers\AppSection\User\Models\User;
use PHPUnit\Framework\Attributes\CoversNothing;

#[CoversNothing]
final class ListUserPermissionsTest extends ApiTestCase
{
    protected string $endpoint = 'get@v1/users/{user_id}/permissions';

    protected array $access = [
        'permissions' => 'manage-permissions',
        'roles' => null,
    ];

    public function testGetUserPermissions(): void
    {
        $user = User::factory()->createOne();
        $permission = Permission::factory()->createOne();
        $user->givePermissionTo([$permission]);

        $response = $this->injectId($user->id, replace: '{user_id}')->makeCall();

        $response->assertOk();
        $responseContent = $this->getResponseContentObject();
        $this->assertSame($permission->name, $responseContent->data[0]->name);
    }
}
