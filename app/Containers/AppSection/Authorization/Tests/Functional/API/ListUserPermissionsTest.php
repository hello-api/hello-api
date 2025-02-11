<?php

namespace App\Containers\AppSection\Authorization\Tests\Functional\API;

use App\Containers\AppSection\Authorization\Models\Permission;
use App\Containers\AppSection\Authorization\Tests\Functional\ApiTestCase;
use App\Containers\AppSection\Authorization\UI\API\Controllers\ListUserPermissionsController;
use App\Containers\AppSection\User\Models\User;
use Illuminate\Testing\Fluent\AssertableJson;
use PHPUnit\Framework\Attributes\CoversNothing;

#[CoversNothing]
final class ListUserPermissionsTest extends ApiTestCase
{
    public function testGetUserPermissions(): void
    {
        $this->actingAs(User::factory()->admin()->createOne());
        $user = User::factory()->createOne();
        $permission = Permission::factory()->createOne();
        $user->givePermissionTo([$permission]);

        $response = $this->getJson(action(
            ListUserPermissionsController::class,
            ['user_id' => $user->getHashedKey()],
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
            ListUserPermissionsController::class,
            ['user_id' => User::factory()->createOne()->getHashedKey()],
        ));

        $response->assertForbidden();
    }
}
