<?php

namespace App\Containers\AppSection\User\Tests\Functional\API;

use App\Containers\AppSection\User\Data\Factories\UserFactory;
use App\Containers\AppSection\User\Enums\Gender;
use App\Containers\AppSection\User\Tests\Functional\ApiTestCase;
use Carbon\CarbonImmutable;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Testing\Fluent\AssertableJson;
use PHPUnit\Framework\Attributes\CoversNothing;
use PHPUnit\Framework\Attributes\Group;

#[Group('user')]
#[CoversNothing]
final class UpdateUserTest extends ApiTestCase
{
    protected string $endpoint = 'patch@v1/users/{user_id}';

    protected array $access = [
        'permissions' => null,
        'roles' => null,
    ];

    public function testCanUpdateAsOwner(): void
    {
        $this->testingUser = UserFactory::new()->createOne([
            'name' => 'He who must not be named',
            'gender' => Gender::FEMALE,
            'password' => 'Av@dakedavra!',
        ]);
        $data = [
            'name' => 'Updated Name',
            'gender' => Gender::MALE->value,
            'birth' => Carbon::today()->toIso8601String(),
            'current_password' => 'Av@dakedavra!',
            'new_password' => 'updated#Password111',
            'new_password_confirmation' => 'updated#Password111',
        ];

        $response = $this->injectId($this->testingUser->id, replace: '{user_id}')->makeCall($data);

        $response->assertOk();
        $response->assertJson(
            fn (AssertableJson $json): AssertableJson => $json->has(
                'data',
                fn (AssertableJson $json): AssertableJson => $json
                    ->where('object', 'User')
                    ->where('email', $this->testingUser->email->value)
                    ->where('name', $data['name'])
                    ->where('gender', $data['gender'])
                    ->where('birth', static fn ($birth) => CarbonImmutable::parse($data['birth'])->isSameDay($birth))
                    ->missing('password')
                    ->etc(),
            )->etc(),
        );
        $this->assertTrue(Hash::check($data['new_password'], $this->testingUser->refresh()->password));
    }
}
