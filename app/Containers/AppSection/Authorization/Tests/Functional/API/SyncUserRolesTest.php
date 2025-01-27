<?php

namespace App\Containers\AppSection\Authorization\Tests\Functional\API;

use App\Containers\AppSection\Authorization\Models\Role;
use App\Containers\AppSection\Authorization\Tests\Functional\ApiTestCase;
use App\Containers\AppSection\User\Models\User;
use Illuminate\Testing\Fluent\AssertableJson;
use PHPUnit\Framework\Attributes\CoversNothing;

#[CoversNothing]
final class SyncUserRolesTest extends ApiTestCase
{
    protected string $endpoint = 'put@v1/users/{user_id}/roles';

    protected array $access = [
        'permissions' => 'manage-admins-access',
        'roles' => null,
    ];

    public function testSyncMultipleRolesOnUser(): void
    {
        $role1 = Role::factory()->createOne();
        $role2 = Role::factory()->createOne();
        $user = User::factory()->createOne();
        $user->assignRole($role1);
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
                ->count('data.roles.data', 2)
                ->where('data.roles.data.0.id', $data['role_ids'][0])
                ->where('data.roles.data.1.id', $data['role_ids'][1])
                ->etc(),
        );
    }

    public function testSyncRoleOnNonExistingUser(): void
    {
        $role = Role::factory()->createOne();
        $invalidId = 7777777;
        $data = [
            'role_ids' => [$role->getHashedKey()],
        ];

        $response = $this->injectId($invalidId, replace: '{user_id}')->makeCall($data);

        $response->assertUnprocessable();
        $response->assertJson(
            static fn (AssertableJson $json): AssertableJson => $json->has('errors')
                ->where('errors.user_id.0', 'The selected user id is invalid.')
                ->etc(),
        );
    }

    public function testSyncNonExistingRoleOnUser(): void
    {
        $user = User::factory()->createOne();
        $invalidId = 7777777;
        $data = [
            'role_ids' => [$this->encode($invalidId)],
        ];

        $response = $this->injectId($user->id, replace: '{user_id}')->makeCall($data);

        $response->assertUnprocessable();
        $response->assertJson(
            static fn (AssertableJson $json): AssertableJson => $json->has(
                'errors',
                static fn (AssertableJson $errors) => $errors->has(
                    'role_ids.0',
                    static fn (AssertableJson $permissionIds) => $permissionIds->where(0, 'The selected role_ids.0 is invalid.'),
                )->etc(),
            )->etc(),
        );
    }
}
