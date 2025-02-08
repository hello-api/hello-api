<?php

namespace App\Containers\AppSection\Authorization\Tests\Functional\API;

use App\Containers\AppSection\Authorization\Models\Role;
use App\Containers\AppSection\Authorization\Tests\Functional\ApiTestCase;
use Illuminate\Testing\Fluent\AssertableJson;
use PHPUnit\Framework\Attributes\CoversNothing;

#[CoversNothing]
final class FindRoleByIdTest extends ApiTestCase
{
    protected string $endpoint = 'get@v1/roles/{role_id}';

    protected array $access = [
        'permissions' => null,
        'roles' => \App\Containers\AppSection\Authorization\Enums\Role::SUPER_ADMIN,
    ];

    public function testFindRoleById(): void
    {
        $roleA = Role::factory()->createOne();

        $response = $this->injectId($roleA->id, replace: '{role_id}')->makeCall();

        $response->assertOk();
        $response->assertJson(
            static fn (AssertableJson $json) => $json->has(
                'data',
                static fn (AssertableJson $json) => $json->where('name', $roleA->name)
                ->etc(),
            )->etc(),
        );
    }

    public function testFindNonExistingRole(): void
    {
        $invalidId = 7777777;

        $response = $this->injectId($invalidId, replace: '{role_id}')->makeCall();

        $response->assertNotFound();
    }
}
