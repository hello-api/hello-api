<?php

namespace App\Containers\AppSection\Authorization\Tests\Functional\API;

use App\Containers\AppSection\Authorization\Models\Permission;
use App\Containers\AppSection\Authorization\Models\Role;
use App\Containers\AppSection\Authorization\Tests\Functional\ApiTestCase;
use App\Containers\AppSection\Authorization\UI\API\Controllers\RevokeRolePermissionsController;
use App\Containers\AppSection\User\Models\User;
use Illuminate\Testing\Fluent\AssertableJson;
use PHPUnit\Framework\Attributes\CoversNothing;

#[CoversNothing]
final class RevokeRolePermissionsTest extends ApiTestCase
{
    public function testDetachSinglePermissionFromRole(): void
    {
        $permissionA = Permission::factory()->createOne();
        $permissionB = Permission::factory()->createOne();
        $role = Role::factory()->createOne();
        $role->givePermissionTo([$permissionA, $permissionB]);
        $data = [
            'permission_ids' => [$permissionA->getHashedKey()],
        ];

        $response = $this->deleteJson(action(
            RevokeRolePermissionsController::class,
            ['role_id' => $role->getHashedKey()],
        ), $data);

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

        $response = $this->deleteJson(action(
            RevokeRolePermissionsController::class,
            ['role_id' => $role->getHashedKey()],
        ), $data);

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

    public function testDetachNonExistingPermissionFromRole(): void
    {
        $role = Role::factory()->createOne();
        $invalidId = 7777777;
        $data = [
            'permission_ids' => [hashids()->encode($invalidId)],
        ];

        $response = $this->deleteJson(action(
            RevokeRolePermissionsController::class,
            ['role_id' => $role->getHashedKey()],
        ), $data);

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

    public function testGivenUserHasNoAccessPreventsOperation(): void
    {
        $this->actingAs(User::factory()->createOne());

        $response = $this->deleteJson(action(
            RevokeRolePermissionsController::class,
            ['role_id' => Role::factory()->createOne()->getHashedKey()],
        ));

        $response->assertForbidden();
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->actingAs(User::factory()->admin()->createOne());
    }
}
