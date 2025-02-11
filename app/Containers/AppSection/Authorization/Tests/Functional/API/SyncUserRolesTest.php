<?php

namespace App\Containers\AppSection\Authorization\Tests\Functional\API;

use App\Containers\AppSection\Authorization\Models\Role;
use App\Containers\AppSection\Authorization\Tests\Functional\ApiTestCase;
use App\Containers\AppSection\Authorization\UI\API\Controllers\SyncUserRolesController;
use App\Containers\AppSection\User\Models\User;
use Illuminate\Testing\Fluent\AssertableJson;
use PHPUnit\Framework\Attributes\CoversNothing;

#[CoversNothing]
final class SyncUserRolesTest extends ApiTestCase
{
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

        $response = $this->putJson(action(
            SyncUserRolesController::class,
            ['user_id' => $user->getHashedKey()],
        ), $data);

        $response->assertOk();
        $response->assertJson(
            static fn (AssertableJson $json): AssertableJson => $json->has('data')
                ->count('data.roles.data', 2)
                ->where('data.roles.data.0.id', $data['role_ids'][0])
                ->where('data.roles.data.1.id', $data['role_ids'][1])
                ->etc(),
        );
    }

    public function testSyncNonExistingRoleOnUser(): void
    {
        $user = User::factory()->createOne();
        $invalidId = 7777777;
        $data = [
            'role_ids' => [hashids()->encode($invalidId)],
        ];

        $response = $this->putJson(action(
            SyncUserRolesController::class,
            ['user_id' => $user->getHashedKey()],
        ), $data);

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

    public function testGivenUserHasNoAccessPreventsOperation(): void
    {
        $this->actingAs(User::factory()->createOne());

        $response = $this->putJson(action(
            SyncUserRolesController::class,
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
