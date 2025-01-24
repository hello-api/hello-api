<?php

namespace App\Containers\AppSection\Authorization\Tests\Functional\API;

use App\Containers\AppSection\Authorization\Models\Role;
use App\Containers\AppSection\Authorization\Tests\Functional\ApiTestCase;
use App\Containers\AppSection\User\Models\User;
use PHPUnit\Framework\Attributes\CoversNothing;

#[CoversNothing]
final class ListUserRolesTest extends ApiTestCase
{
    protected string $endpoint = 'get@v1/users/{user_id}/roles';

    protected array $access = [
        'permissions' => 'manage-roles',
        'roles' => null,
    ];

    public function testGetUserRoles(): void
    {
        $user = User::factory()->createOne();
        $role = Role::factory()->createOne();
        $user->assignRole($role);

        $response = $this->injectId($user->id, replace: '{user_id}')->makeCall();

        $response->assertOk();
        $responseContent = $this->getResponseContentObject();
        $this->assertSame($role->name, $responseContent->data[0]->name);
    }
}
