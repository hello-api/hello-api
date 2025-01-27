<?php

namespace App\Containers\AppSection\Authentication\Tests\Unit\Notifications;

use App\Containers\AppSection\Authentication\Notifications\VerifyEmail;
use App\Containers\AppSection\Authentication\Tests\UnitTestCase;
use App\Containers\AppSection\User\Models\User;
use Illuminate\Support\Facades\Notification;
use PHPUnit\Framework\Attributes\CoversClass;

#[CoversClass(VerifyEmail::class)]
final class VerifyEmailTest extends UnitTestCase
{
    public function testSendMail(): void
    {
        Notification::fake();
        Notification::assertNothingSent();
        $user = User::factory()->createOne();

        $user->notify(new VerifyEmail('https://example.com'));

        Notification::assertSentTo($user, VerifyEmail::class, function (VerifyEmail $notification) use ($user) {
            $email = $notification->toMail($user);
            $this->assertSame('Verify Email Address', $email->subject);
            $this->assertSame([
                'Please click the below button to verify your email address.',
            ], $email->introLines);
            $this->assertSame([
                'If you did not create an account, no further action is required.',
            ], $email->outroLines);
            $this->assertSame('Verify Email Address', $email->actionText);

            return true;
        });
        Notification::assertCount(1);
    }
}
