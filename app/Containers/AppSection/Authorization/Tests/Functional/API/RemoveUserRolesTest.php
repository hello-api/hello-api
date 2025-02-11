<?php

namespace App\Containers\AppSection\Authorization\Tests\Functional\API;

use App\Containers\AppSection\Authorization\Models\Role;
use App\Containers\AppSection\Authorization\Tests\Functional\ApiTestCase;
use App\Containers\AppSection\Authorization\UI\API\Controllers\RemoveUserRolesController;
use App\Containers\AppSection\User\Models\User;
use Illuminate\Testing\Fluent\AssertableJson;
use PHPUnit\Framework\Attributes\CoversNothing;

#[CoversNothing]
final class RemoveUserRolesTest extends ApiTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->actingAs(User::factory()->admin()->createOne());
    }

    public function testRevokeRolesFromUser(): void
    {
        $roleA = Role::factory()->createOne();
        $roleB = Role::factory()->createOne();
        $user = User::factory()->createOne();
        $user->assignRole($roleA, $roleB);
        $data = [
            'role_ids' => [$roleA->getHashedKey()],
        ];

        $response = $this->deleteJson(action(RemoveUserRolesController::class, ['user_id' => $user->getHashedKey()]), $data);

        $response->assertOk();
        $response->assertJson(
            static fn (AssertableJson $json): AssertableJson => $json->has('data')
                ->where('data.object', 'User')
                ->where('data.id', $user->getHashedKey())
                ->has('data.roles.data', 1)
                ->where('data.roles.data.0.id', $roleB->getHashedKey())
                ->etc(),
        );
    }

    public function testRevokeManyRolesFromUser(): void
    {
        $roleA = Role::factory()->createOne();
        $roleB = Role::factory()->createOne();
        $user = User::factory()->createOne();
        $user->assignRole($roleA);
        $user->assignRole($roleB);

        $data = [
            'role_ids' => [$roleA->getHashedKey(), $roleB->getHashedKey()],
        ];

        $response = $this->deleteJson(action(RemoveUserRolesController::class, ['user_id' => $user->getHashedKey()]), $data);

        $response->assertOk();
        $response->assertJson(
            static fn (AssertableJson $json): AssertableJson => $json->has('data')
                ->where('data.object', 'User')
                ->where('data.id', $user->getHashedKey())
                ->has('data.roles.data', 0)
                ->etc(),
        );
    }

    public function testRevokeNonExistingRoleFromUser(): void
    {
        $user = User::factory()->createOne();
        $invalidId = 7777777;
        $data = [
            'role_ids' => [hashids()->encode($invalidId)],
        ];

        $response = $this->deleteJson(action(RemoveUserRolesController::class, ['user_id' => $user->getHashedKey()]), $data);

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

        $response = $this->deleteJson(action(RemoveUserRolesController::class, ['user_id' => User::factory()->createOne()->getHashedKey()]));

        $response->assertForbidden();
    }
}
