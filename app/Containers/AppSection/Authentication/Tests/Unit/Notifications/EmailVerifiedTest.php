<?php

namespace App\Containers\AppSection\Authentication\Tests\Unit\Notifications;

use App\Containers\AppSection\Authentication\Notifications\EmailVerified;
use App\Containers\AppSection\Authentication\Tests\UnitTestCase;
use App\Containers\AppSection\User\Models\User;
use Illuminate\Support\Facades\Notification;
use PHPUnit\Framework\Attributes\CoversClass;

#[CoversClass(EmailVerified::class)]
final class EmailVerifiedTest extends UnitTestCase
{
    public function testCanSendMail(): void
    {
        Notification::fake();
        Notification::assertNothingSent();
        $user = User::factory()->createOne();

        $user->notify(new EmailVerified());

        Notification::assertSentTo($user, EmailVerified::class, function (EmailVerified $notification) use ($user) {
            $email = $notification->toMail($user);
            $this->assertSame('Email Verified', $email->subject);
            $this->assertSame(['Your email has been verified.'], $email->introLines);

            return true;
        });
        Notification::assertCount(1);
    }
}
