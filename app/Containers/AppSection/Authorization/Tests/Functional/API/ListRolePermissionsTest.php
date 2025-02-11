<?php

namespace App\Containers\AppSection\Authorization\Tests\Functional\API;

use App\Containers\AppSection\Authorization\Models\Permission;
use App\Containers\AppSection\Authorization\Models\Role;
use App\Containers\AppSection\Authorization\Tests\Functional\ApiTestCase;
use App\Containers\AppSection\Authorization\UI\API\Controllers\ListRolePermissionsController;
use App\Containers\AppSection\User\Models\User;
use Illuminate\Testing\Fluent\AssertableJson;
use PHPUnit\Framework\Attributes\CoversNothing;

#[CoversNothing]
final class ListRolePermissionsTest extends ApiTestCase
{
    public function testGetRolePermissions(): void
    {
        $this->actingAs(User::factory()->admin()->createOne());
        $role = Role::factory()->createOne();
        $permission = Permission::factory()->createOne();
        $role->givePermissionTo([$permission]);

        $response = $this->getJson(action(
            ListRolePermissionsController::class,
            ['role_id' => $role->getHashedKey()],
        ));

        $response->assertOk();
        $response->assertJson(
            static fn (AssertableJson $json) => $json->has(
                'data',
                static fn (AssertableJson $json) => $json->where('0.name', $permission->name)
                ->etc(),
            )->etc(),
        );
    }

    public function testGivenUserHasNoAccessPreventsOperation(): void
    {
        $this->actingAs(User::factory()->createOne());

        $response = $this->getJson(action(
            ListRolePermissionsController::class,
            ['role_id' => Role::factory()->createOne()->getHashedKey()],
        ));

        $response->assertForbidden();
    }
}
