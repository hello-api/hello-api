<?php

namespace App\Containers\AppSection\Authorization\Tests\Functional\API;

use App\Containers\AppSection\Authorization\Models\Permission;
use App\Containers\AppSection\Authorization\Models\Role;
use App\Containers\AppSection\Authorization\Tests\Functional\ApiTestCase;
use App\Containers\AppSection\Authorization\UI\API\Controllers\GivePermissionsToRoleController;
use App\Containers\AppSection\User\Models\User;
use Illuminate\Testing\Fluent\AssertableJson;
use PHPUnit\Framework\Attributes\CoversNothing;

#[CoversNothing]
final class GivePermissionsToRoleTest extends ApiTestCase
{
    public function testAttachSinglePermissionToRole(): void
    {
        $role = Role::factory()->createOne();
        $permission = Permission::factory()->createOne();
        $data = [
            'permission_ids' => [$permission->getHashedKey()],
        ];

        $response = $this->postJson(action(
            GivePermissionsToRoleController::class,
            ['role_id' => $role->getHashedKey()],
        ), $data);

        $response->assertOk();
        $response->assertJson(
            static fn (AssertableJson $json): AssertableJson => $json->has('data')
                ->where('data.object', 'Role')
                ->where('data.id', $role->getHashedKey())
                ->has('data.permissions.data', 1)
                ->where('data.permissions.data.0.object', 'Permission')
                ->where('data.permissions.data.0.id', $permission->getHashedKey())
                ->etc(),
        );
    }

    public function testAttachMultiplePermissionsToRole(): void
    {
        $role = Role::factory()->createOne();
        $permissionA = Permission::factory()->createOne();
        $permissionB = Permission::factory()->createOne();
        $data = [
            'permission_ids' => [$permissionA->getHashedKey(), $permissionB->getHashedKey()],
        ];

        $response = $this->postJson(action(
            GivePermissionsToRoleController::class,
            ['role_id' => $role->getHashedKey()],
        ), $data);

        $response->assertOk();
        $response->assertJson(
            static fn (AssertableJson $json): AssertableJson => $json->has('data')
                ->where('data.object', 'Role')
                ->where('data.id', $role->getHashedKey())
                ->has('data.permissions.data', 2)
                ->where('data.permissions.data.0.object', 'Permission')
                ->where('data.permissions.data.0.id', $permissionA->getHashedKey())
                ->where('data.permissions.data.1.id', $permissionB->getHashedKey())
                ->etc(),
        );
    }

    public function testAttachNonExistingPermissionToRole(): void
    {
        $role = Role::factory()->createOne();
        $invalidId = 7777777;
        $data = [
            'permission_ids' => [hashids()->encode($invalidId)],
        ];

        $response = $this->postJson(action(
            GivePermissionsToRoleController::class,
            ['role_id' => $role->getHashedKey()],
        ), $data);

        $response->assertUnprocessable();
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

        $response = $this->postJson(action(
            GivePermissionsToRoleController::class,
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
