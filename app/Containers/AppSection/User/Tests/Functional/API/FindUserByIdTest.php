<?php

namespace App\Containers\AppSection\User\Tests\Functional\API;

use App\Containers\AppSection\User\Models\User;
use App\Containers\AppSection\User\Tests\Functional\ApiTestCase;
use Illuminate\Testing\Fluent\AssertableJson;
use PHPUnit\Framework\Attributes\CoversNothing;

#[CoversNothing]
final class FindUserByIdTest extends ApiTestCase
{
    protected string $endpoint = 'get@v1/users/{user_id}';

    protected array $access = [
        'permissions' => null,
        'roles' => null,
    ];

    public function testCanFindSelfAsAdmin(): void
    {
        $this->testingUser = User::factory()->admin()->createOne();

        $response = $this->injectId($this->testingUser->id, replace: '{user_id}')->makeCall();

        $response->assertOk();
        $response->assertJson(
            fn (AssertableJson $json): AssertableJson => $json->has('data')
                ->where('data.id', $this->encode($this->testingUser->id))
                ->etc(),
        );
    }

    public function testCanFindAnotherUserAsAdmin(): void
    {
        $this->testingUser = User::factory()->admin()->createOne();

        $response = $this->injectId(User::factory()->createOne()->id, replace: '{user_id}')->makeCall();

        $response->assertOk();
    }
}
