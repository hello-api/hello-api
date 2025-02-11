<?php

namespace App\Containers\AppSection\User\Tests\Functional\API;

use App\Containers\AppSection\User\Models\User;
use App\Containers\AppSection\User\Tests\Functional\ApiTestCase;
use App\Containers\AppSection\User\UI\API\Controllers\UpdatePasswordController;
use Illuminate\Support\Facades\Hash;
use Illuminate\Testing\Fluent\AssertableJson;
use PHPUnit\Framework\Attributes\CoversNothing;

#[CoversNothing]
final class UpdatePasswordTest extends ApiTestCase
{
    public function testCanUpdatePasswordAsOwner(): void
    {
        $user = User::factory()->createOne([
            'password' => 'Av@dakedavra!',
        ]);
        $this->actingAs($user);
        $data = [
            'current_password' => 'Av@dakedavra!',
            'new_password' => 'updated#Password111',
            'new_password_confirmation' => 'updated#Password111',
        ];

        $response = $this->patch(action(
            UpdatePasswordController::class,
            ['user_id' => $user->getHashedKey()],
        ), $data);

        $response->assertOk();
        $response->assertJson(
            fn (AssertableJson $json): AssertableJson => $json->has(
                'data',
                fn (AssertableJson $json): AssertableJson => $json
                    ->where('object', 'User')
                    ->where('email', $user->email)
                    ->missing('password')
                    ->etc(),
            )->etc(),
        );
        $this->assertTrue(Hash::check($data['new_password'], $user->refresh()->password));
    }

    public function testGivenUserHasNoAccessPreventsOperation(): void
    {
        $this->actingAs(User::factory()->createOne());

        $response = $this->patch(action(
            UpdatePasswordController::class,
            ['user_id' => User::factory()->createOne()->getHashedKey()],
        ));

        $response->assertForbidden();
    }
}
