<?php

namespace App\Containers\AppSection\Authorization\Tests\Functional\API;

use App\Containers\AppSection\Authorization\Models\Role;
use App\Containers\AppSection\Authorization\Tests\Functional\ApiTestCase;
use App\Containers\AppSection\Authorization\UI\API\Controllers\ListUserRolesController;
use App\Containers\AppSection\User\Models\User;
use Illuminate\Testing\Fluent\AssertableJson;
use PHPUnit\Framework\Attributes\CoversNothing;

#[CoversNothing]
final class ListUserRolesTest extends ApiTestCase
{
    public function testGetUserRoles(): void
    {
        $this->actingAs(User::factory()->admin()->createOne());
        $user = User::factory()->createOne();
        $role = Role::factory()->createOne();
        $user->assignRole($role);

        $response = $this->getJson(action(
            ListUserRolesController::class,
            ['user_id' => $user->getHashedKey()],
        ));

        $response->assertOk();
        $response->assertJson(
            static fn (AssertableJson $json) => $json->has(
                'data',
                static fn (AssertableJson $json) => $json->where('0.name', $role->name)
                ->etc(),
            )->etc(),
        );
    }

    public function testGivenUserHasNoAccessPreventsOperation(): void
    {
        $this->actingAs(User::factory()->createOne());

        $response = $this->getJson(action(
            ListUserRolesController::class,
            ['user_id' => User::factory()->createOne()->getHashedKey()],
        ));

        $response->assertForbidden();
    }
}
