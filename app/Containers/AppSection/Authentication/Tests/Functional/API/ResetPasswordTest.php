<?php

namespace App\Containers\AppSection\Authentication\Tests\Functional\API;

use App\Containers\AppSection\Authentication\Tasks\CreatePasswordResetTokenTask;
use App\Containers\AppSection\Authentication\Tests\Functional\ApiTestCase;
use App\Containers\AppSection\Authentication\UI\API\Controllers\ResetPasswordController;
use App\Containers\AppSection\User\Models\User;
use Illuminate\Testing\Fluent\AssertableJson;
use PHPUnit\Framework\Attributes\CoversNothing;

#[CoversNothing]
final class ResetPasswordTest extends ApiTestCase
{
    public function testResetPassword(): void
    {
        $user = User::factory()->createOne([
            'email' => 'ganldalf@the.grey',
            'password' => 'youShallNotPass',
        ]);
        $token = app(CreatePasswordResetTokenTask::class)->run($user);
        $data = [
            'email' => $user->email,
            'password' => 's3cr3tPa$$',
            'token' => $token,
        ];

        $response = $this->postJson(action(ResetPasswordController::class), $data);

        $response->assertNoContent();
    }

    public function testResetPasswordWithInvalidEmail(): void
    {
        $data = [
            'email' => 'missing-at.test',
        ];

        $response = $this->postJson(action(ResetPasswordController::class), $data);

        $response->assertUnprocessable();
        $response->assertJson(
            static fn (AssertableJson $json): AssertableJson => $json->has('errors')
                ->where('errors.email.0', 'The email field must be a valid email address.')
                ->etc(),
        );
    }

    public function testResetPasswordWithInvalidPassword(): void
    {
        $data = [
            'password' => '((((()))))',
        ];

        $response = $this->postJson(action(ResetPasswordController::class), $data);

        $response->assertUnprocessable();
        $response->assertJson(
            static fn (AssertableJson $json): AssertableJson => $json->has('errors')
                ->has(
                    'errors.password',
                    static fn (AssertableJson $json): AssertableJson => $json
                        ->where('0', 'The password field must contain at least one uppercase and one lowercase letter.')
                        ->where('1', 'The password field must contain at least one letter.')
                        ->where('2', 'The password field must contain at least one number.'),
                )
                ->etc(),
        );
    }
}
