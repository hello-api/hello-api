<?php

namespace App\Containers\AppSection\Authorization\Tests\Functional\API;

use App\Containers\AppSection\Authorization\Models\Role;
use App\Containers\AppSection\Authorization\Tests\Functional\ApiTestCase;
use PHPUnit\Framework\Attributes\CoversNothing;

#[CoversNothing]
final class FindRoleByIdTest extends ApiTestCase
{
    protected string $endpoint = 'get@v1/roles/{role_id}';

    protected array $access = [
        'permissions' => 'manage-roles',
        'roles' => null,
    ];

    public function testFindRoleById(): void
    {
        $roleA = Role::factory()->createOne();

        $response = $this->injectId($roleA->id, replace: '{role_id}')->makeCall();

        $response->assertOk();
        $responseContent = $this->getResponseContentObject();
        $this->assertSame($roleA->name, $responseContent->data->name);
    }

    public function testFindNonExistingRole(): void
    {
        $invalidId = 7777777;

        $response = $this->injectId($invalidId, replace: '{role_id}')->makeCall();

        $response->assertNotFound();
    }
}
