<?php

namespace App\Containers\AppSection\Authentication\Tests\Unit\Actions;

use App\Containers\AppSection\Authentication\Actions\ResetPasswordAction;
use App\Containers\AppSection\Authentication\Exceptions\InvalidResetPasswordToken;
use App\Containers\AppSection\Authentication\Notifications\PasswordReset;
use App\Containers\AppSection\Authentication\Tasks\CreatePasswordResetTokenTask;
use App\Containers\AppSection\Authentication\Tests\UnitTestCase;
use App\Containers\AppSection\Authentication\UI\API\Requests\ResetPasswordRequest;
use App\Containers\AppSection\User\Models\User;
use App\Ship\Exceptions\ResourceNotFound;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use PHPUnit\Framework\Attributes\CoversClass;

#[CoversClass(ResetPasswordAction::class)]
final class ResetPasswordActionTest extends UnitTestCase
{
    private User $user;

    public function testCanResetPassword(): void
    {
        Notification::fake();
        $token = app(CreatePasswordResetTokenTask::class)->run($this->user);
        $data = [
            'email' => $this->user->email,
            'token' => $token,
            'password' => 'new pass',
            'password_confirmation' => 'new pass',
        ];
        $request = new ResetPasswordRequest($data);

        app(ResetPasswordAction::class)->run($request);

        $this->assertTrue(Hash::check($data['password'], $this->user->fresh()->password));
        Notification::assertSentTo($this->user, PasswordReset::class);
    }

    public function testResetPasswordWithInvalidTokenThrowsException(): void
    {
        $this->expectException(InvalidResetPasswordToken::class);
        $this->expectExceptionMessage('Invalid Reset Password Token.');

        $data = [
            'email' => $this->user->email,
            'password' => 'new pass',
            'token' => 'invalid token',
        ];
        $request = new ResetPasswordRequest($data);

        app(ResetPasswordAction::class)->run($request);
    }

    public function testResetPasswordWithInvalidEmailThrowsException(): void
    {
        $this->expectException(ResourceNotFound::class);
        $this->expectExceptionMessage('User not found.');

        $token = app(CreatePasswordResetTokenTask::class)->run($this->user);
        $data = [
            'email' => 'ganldalf@the.white',
            'password' => 'youShallNotPass',
            'token' => $token,
        ];
        $request = new ResetPasswordRequest($data);

        app(ResetPasswordAction::class)->run($request);
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->createOne([
            'email' => 'ganldalf@the.grey',
            'password' => 'youShallNotPass',
        ]);
    }
}
