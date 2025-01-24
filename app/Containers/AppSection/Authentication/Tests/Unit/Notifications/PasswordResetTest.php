<?php

namespace App\Containers\AppSection\Authentication\Tests\Unit\Notifications;

use App\Containers\AppSection\Authentication\Notifications\PasswordReset;
use App\Containers\AppSection\Authentication\Tests\UnitTestCase;
use App\Containers\AppSection\User\Models\User;
use Illuminate\Support\Facades\Notification;
use PHPUnit\Framework\Attributes\CoversClass;

#[CoversClass(PasswordReset::class)]
final class PasswordResetTest extends UnitTestCase
{
    public function testSendMail(): void
    {
        Notification::fake();
        Notification::assertNothingSent();
        $user = User::factory()->createOne();

        $user->notify(new PasswordReset());

        Notification::assertSentTo($user, PasswordReset::class, function (PasswordReset $notification) use ($user) {
            $email = $notification->toMail($user);
            $this->assertSame('Password Reset', $email->subject);
            $this->assertSame(['Your password has been reset successfully.'], $email->introLines);

            return true;
        });
        Notification::assertCount(1);
    }
}
