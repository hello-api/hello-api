<?php

namespace App\Containers\AppSection\Authorization\Tests\Functional\API;

use App\Containers\AppSection\Authorization\Tests\Functional\ApiTestCase;
use App\Containers\AppSection\Authorization\UI\API\Controllers\CreateRoleController;
use App\Containers\AppSection\User\Models\User;
use Illuminate\Testing\Fluent\AssertableJson;
use PHPUnit\Framework\Attributes\CoversNothing;

#[CoversNothing]
final class CreateRoleTest extends ApiTestCase
{
    public function testCreateRole(): void
    {
        $this->actingAs(User::factory()->admin()->createOne());

        $data = [
            'name' => 'manager',
            'display_name' => 'manager',
            'description' => 'he manages things',
        ];

        $response = $this->postJson(action(CreateRoleController::class), $data);

        $response->assertCreated();
        $response->assertJson(
            static fn (AssertableJson $json) => $json->has(
                'data',
                static fn (AssertableJson $json) => $json->where('name', $data['name'])
                ->etc(),
            )->etc(),
        );
    }

    public function testCreateRoleWithWrongName(): void
    {
        $this->actingAs(User::factory()->admin()->createOne());

        $data = [
            'name' => 'includes Space',
            'display_name' => 'manager',
            'description' => 'he manages things',
        ];

        $response = $this->postJson(action(CreateRoleController::class), $data);

        $response->assertUnprocessable();
        $response->assertJson(
            static fn (AssertableJson $json): AssertableJson => $json->has('message')
                    ->has('errors')
                    ->where('errors.name.0', 'The name field must only contain letters.'),
        );
    }

    public function testGivenUserHasNoAccessPreventsOperation(): void
    {
        $this->actingAs(User::factory()->createOne());

        $response = $this->postJson(action(CreateRoleController::class));

        $response->assertForbidden();
    }
}
