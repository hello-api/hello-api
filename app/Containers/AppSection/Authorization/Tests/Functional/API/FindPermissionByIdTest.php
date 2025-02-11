<?php

namespace App\Containers\AppSection\Authorization\Tests\Functional\API;

use App\Containers\AppSection\Authorization\Models\Permission;
use App\Containers\AppSection\Authorization\Tests\Functional\ApiTestCase;
use App\Containers\AppSection\Authorization\UI\API\Controllers\FindPermissionByIdController;
use App\Containers\AppSection\User\Models\User;
use Illuminate\Testing\Fluent\AssertableJson;
use PHPUnit\Framework\Attributes\CoversNothing;

#[CoversNothing]
final class FindPermissionByIdTest extends ApiTestCase
{
    public function testCanFindPermissionById(): void
    {
        $this->actingAs(User::factory()->admin()->createOne());
        $permission = Permission::factory()->createOne();

        $response = $this->getJson(action(
            FindPermissionByIdController::class,
            ['permission_id' => $permission->getHashedKey()],
        ));

        $response->assertOk();
        $response->assertJson(
            static fn (AssertableJson $json) => $json->has(
                'data',
                static fn (AssertableJson $json) => $json->where('name', $permission->name)
                    ->etc(),
            )->etc(),
        );
    }

    public function testGivenUserHasNoAccessPreventsOperation(): void
    {
        $this->actingAs(User::factory()->createOne());

        $response = $this->getJson(action(
            FindPermissionByIdController::class,
            ['permission_id' => Permission::factory()->createOne()->getHashedKey()],
        ));

        $response->assertForbidden();
    }
}
