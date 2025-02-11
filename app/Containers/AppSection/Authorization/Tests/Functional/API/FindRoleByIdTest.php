<?php

namespace App\Containers\AppSection\Authorization\Tests\Functional\API;

use App\Containers\AppSection\Authorization\Models\Role;
use App\Containers\AppSection\Authorization\Tests\Functional\ApiTestCase;
use App\Containers\AppSection\Authorization\UI\API\Controllers\FindRoleByIdController;
use App\Containers\AppSection\User\Models\User;
use Illuminate\Testing\Fluent\AssertableJson;
use PHPUnit\Framework\Attributes\CoversNothing;

#[CoversNothing]
final class FindRoleByIdTest extends ApiTestCase
{
    public function testCanFindRoleById(): void
    {
        $this->actingAs(User::factory()->admin()->createOne());
        $roleA = Role::factory()->createOne();

        $response = $this->getJson(action(
            FindRoleByIdController::class,
            ['role_id' => $roleA->getHashedKey()],
        ));

        $response->assertOk();
        $response->assertJson(
            static fn (AssertableJson $json) => $json->has(
                'data',
                static fn (AssertableJson $json) => $json->where('name', $roleA->name)
                ->etc(),
            )->etc(),
        );
    }

    public function testGivenUserHasNoAccessPreventsOperation(): void
    {
        $this->actingAs(User::factory()->createOne());

        $response = $this->getJson(action(
            FindRoleByIdController::class,
            ['role_id' => Role::factory()->createOne()->getHashedKey()],
        ));

        $response->assertForbidden();
    }
}
