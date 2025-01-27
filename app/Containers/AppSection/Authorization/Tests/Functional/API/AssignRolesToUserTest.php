<?php

namespace App\Containers\AppSection\Authorization\Tests\Functional\API;

use App\Containers\AppSection\Authorization\Models\Role;
use App\Containers\AppSection\Authorization\Tests\Functional\ApiTestCase;
use App\Containers\AppSection\User\Models\User;
use Illuminate\Testing\Fluent\AssertableJson;
use PHPUnit\Framework\Attributes\CoversNothing;

#[CoversNothing]
final class AssignRolesToUserTest extends ApiTestCase
{
    protected string $endpoint = 'patch@v1/users/{user_id}/roles';

    protected array $access = [
        'permissions' => 'manage-admins-access',
        'roles' => null,
    ];

    public function testAssignRoleToUser(): void
    {
        $user = User::factory()->createOne();
        $role = Role::factory()->createOne();
        $data = [
            'role_ids' => [$role->getHashedKey()],
        ];

        $response = $this->injectId($user->id, replace: '{user_id}')->makeCall($data);

        $response->assertOk();
        $response->assertJson(
            static fn (AssertableJson $json): AssertableJson => $json->has('data')
                ->has('data.roles.data', 1)
                ->where('data.id', $user->getHashedKey())
                ->where('data.roles.data.0.id', $data['role_ids'][0])
                ->etc(),
        );
    }

    public function testAssignManyRolesToUser(): void
    {
        $user = User::factory()->createOne();
        $role1 = Role::factory()->createOne();
        $role2 = Role::factory()->createOne();
        $data = [
            'role_ids' => [
                $role1->getHashedKey(),
                $role2->getHashedKey(),
            ],
        ];

        $response = $this->injectId($user->id, replace: '{user_id}')->makeCall($data);

        $response->assertOk();
        $response->assertJson(
            static fn (AssertableJson $json): AssertableJson => $json->has('data')
                ->has('data.roles.data', 2)
                ->where('data.id', $user->getHashedKey())
                ->where('data.roles.data.0.id', $data['role_ids'][0])
                ->where('data.roles.data.1.id', $data['role_ids'][1])
                ->etc(),
        );
    }
}
