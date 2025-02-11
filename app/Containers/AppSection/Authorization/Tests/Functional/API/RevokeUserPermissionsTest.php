<?php

namespace App\Containers\AppSection\Authorization\Tests\Functional\API;

use App\Containers\AppSection\Authorization\Models\Permission;
use App\Containers\AppSection\Authorization\Tests\Functional\ApiTestCase;
use App\Containers\AppSection\Authorization\UI\API\Controllers\RevokeUserPermissionsController;
use App\Containers\AppSection\User\Models\User;
use Illuminate\Testing\Fluent\AssertableJson;
use PHPUnit\Framework\Attributes\CoversNothing;

#[CoversNothing]
final class RevokeUserPermissionsTest extends ApiTestCase
{
    public function testDetachSinglePermissionFromUser(): void
    {
        $user = User::factory()->createOne();
        $permissionA = Permission::factory()->createOne();
        $permissionB = Permission::factory()->createOne();
        $user->givePermissionTo([$permissionA, $permissionB]);
        $data = [
            'permission_ids' => [$permissionA->getHashedKey()],
        ];

        $response = $this->deleteJson(action(
            RevokeUserPermissionsController::class,
            ['user_id' => $user->getHashedKey()],
        ), $data);

        $response->assertOk();
        $response->assertJson(
            static fn (AssertableJson $json): AssertableJson => $json->has('data')
                ->where('data.object', 'User')
                ->where('data.id', $user->getHashedKey())
                ->has('data.permissions.data', 1)
                ->where('data.permissions.data.0.object', 'Permission')
                ->where('data.permissions.data.0.id', $permissionB->getHashedKey())
                ->etc(),
        );
    }

    public function testDetachMultiplePermissionFromUser(): void
    {
        $user = User::factory()->createOne();
        $permissionA = Permission::factory()->createOne();
        $permissionB = Permission::factory()->createOne();
        $permissionC = Permission::factory()->createOne();
        $user->givePermissionTo([$permissionA, $permissionB, $permissionC]);
        $data = [
            'permission_ids' => [$permissionA->getHashedKey(), $permissionB->getHashedKey()],
        ];

        $response = $this->deleteJson(action(
            RevokeUserPermissionsController::class,
            ['user_id' => $user->getHashedKey()],
        ), $data);

        $response->assertOk();
        $response->assertJson(
            static fn (AssertableJson $json): AssertableJson => $json->has('data')
                ->where('data.object', 'User')
                ->where('data.id', $user->getHashedKey())
                ->count('data.permissions.data', 1)
                ->where('data.permissions.data.0.id', $permissionC->getHashedKey())
                ->etc(),
        );
    }

    public function testDetachNonExistingPermissionFromUser(): void
    {
        $user = User::factory()->createOne();
        $invalidId = 7777777;
        $data = [
            'permission_ids' => [hashids()->encode($invalidId)],
        ];

        $response = $this->deleteJson(action(
            RevokeUserPermissionsController::class,
            ['user_id' => $user->getHashedKey()],
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

        $response = $this->deleteJson(action(
            RevokeUserPermissionsController::class,
            ['user_id' => User::factory()->createOne()->getHashedKey()],
        ));

        $response->assertForbidden();
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->actingAs(User::factory()->admin()->createOne());
    }
}
