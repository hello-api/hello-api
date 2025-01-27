<?php

namespace App\Containers\AppSection\Authorization\Tests\Functional\API;

use App\Containers\AppSection\Authorization\Models\Permission;
use App\Containers\AppSection\Authorization\Models\Role;
use App\Containers\AppSection\Authorization\Tests\Functional\ApiTestCase;
use Illuminate\Testing\Fluent\AssertableJson;
use PHPUnit\Framework\Attributes\CoversNothing;

#[CoversNothing]
final class RevokeRolePermissionsTest extends ApiTestCase
{
    protected string $endpoint = 'delete@v1/roles/{role_id}/permissions';

    protected array $access = [
        'permissions' => 'manage-roles',
        'roles' => null,
    ];

    public function testDetachSinglePermissionFromRole(): void
    {
        $permissionA = Permission::factory()->createOne();
        $permissionB = Permission::factory()->createOne();
        $role = Role::factory()->createOne();
        $role->givePermissionTo([$permissionA, $permissionB]);
        $data = [
            'permission_ids' => [$permissionA->getHashedKey()],
        ];

        $response = $this->injectId($role->id, replace: '{role_id}')->makeCall($data);

        $response->assertOk();
        $response->assertJson(
            static fn (AssertableJson $json): AssertableJson => $json->has('data')
                ->where('data.object', 'Role')
                ->where('data.id', $role->getHashedKey())
                ->count('data.permissions.data', 1)
                ->where('data.permissions.data.0.id', $permissionB->getHashedKey())
                ->etc(),
        );
    }

    public function testDetachMultiplePermissionFromRole(): void
    {
        $permissionA = Permission::factory()->createOne();
        $permissionB = Permission::factory()->createOne();
        $permissionC = Permission::factory()->createOne();
        $role = Role::factory()->createOne();
        $role->givePermissionTo([$permissionA, $permissionB, $permissionC]);
        $data = [
            'permission_ids' => [$permissionA->getHashedKey(), $permissionC->getHashedKey()],
        ];

        $response = $this->injectId($role->id, replace: '{role_id}')->makeCall($data);

        $response->assertOk();
        $response->assertJson(
            static fn (AssertableJson $json): AssertableJson => $json->has('data')
                ->where('data.object', 'Role')
                ->where('data.id', $role->getHashedKey())
                ->count('data.permissions.data', 1)
                ->where('data.permissions.data.0.id', $permissionB->getHashedKey())
                ->etc(),
        );
    }

    public function testDetachPermissionFromNonExistingRole(): void
    {
        $permission = Permission::factory()->createOne();
        $invalidId = 7777777;
        $data = [
            'permission_ids' => [$permission->getHashedKey()],
        ];

        $response = $this->injectId($invalidId, replace: '{role_id}')->makeCall($data);

        $response->assertUnprocessable();
        $response->assertJson(
            static fn (AssertableJson $json): AssertableJson => $json->has('errors')
                ->where('errors.role_id.0', 'The selected role id is invalid.')
                ->etc(),
        );
    }

    public function testDetachNonExistingPermissionFromRole(): void
    {
        $role = Role::factory()->createOne();
        $invalidId = 7777777;
        $data = [
            'permission_ids' => [$this->encode($invalidId)],
        ];

        $response = $this->injectId($role->id, replace: '{role_id}')->makeCall($data);

        $response->assertJson(
            static fn (AssertableJson $json): AssertableJson => $json->has(
                'errors',
                static fn (AssertableJson $errors) => $errors->has(
                    'permission_ids.0',
                    static fn (AssertableJson $permissionIds) => $permissionIds->where('0', 'The selected permission_ids.0 is invalid.'),
                )->etc(),
            )->etc(),
        );
    }
}
