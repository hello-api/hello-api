<?php

namespace App\Containers\AppSection\User\Tests\Functional\API;

use App\Containers\AppSection\User\Models\User;
use App\Containers\AppSection\User\Tests\Functional\ApiTestCase;
use App\Containers\AppSection\User\UI\API\Controllers\FindUserByIdController;
use Illuminate\Testing\Fluent\AssertableJson;
use PHPUnit\Framework\Attributes\CoversNothing;

#[CoversNothing]
final class FindUserByIdTest extends ApiTestCase
{
    public function testCanFindSelf(): void
    {
        $user = User::factory()->createOne();
        $this->actingAs($user);

        $response = $this->getJson(action(FindUserByIdController::class, ['user_id' => $user->getHashedKey()]));

        $response->assertOk();
        $response->assertJson(
            fn (AssertableJson $json): AssertableJson => $json->has('data')
                ->where('data.id', $user->getHashedKey())
                ->etc(),
        );
    }
}
