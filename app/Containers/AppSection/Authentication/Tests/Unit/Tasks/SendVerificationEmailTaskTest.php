<?php

namespace App\Containers\AppSection\Authentication\Tests\Unit\Tasks;

use App\Containers\AppSection\Authentication\Notifications\VerifyEmail;
use App\Containers\AppSection\Authentication\Tasks\SendVerificationEmailTask;
use App\Containers\AppSection\Authentication\Tests\UnitTestCase;
use App\Containers\AppSection\User\Models\User;
use Illuminate\Support\Facades\Notification;
use PHPUnit\Framework\Attributes\CoversClass;

#[CoversClass(SendVerificationEmailTask::class)]
final class SendVerificationEmailTaskTest extends UnitTestCase
{
    public function testGivenEmailVerificationEnabledSendVerificationEmail(): void
    {
        Notification::fake();
        $unverifiedUser = User::factory()->unverified()->createOne();
        config()->set('appSection-authentication.require_email_verification', true);

        app(SendVerificationEmailTask::class)->run($unverifiedUser, 'this_doesnt_matter_for_the_test');

        Notification::assertSentTo($unverifiedUser, VerifyEmail::class);
    }

    public function testGivenEmailVerificationDisabledShouldNotSendVerificationEmail(): void
    {
        Notification::fake();
        $unverifiedUser = User::factory()->unverified()->createOne();
        config()->set('appSection-authentication.require_email_verification', false);

        app(SendVerificationEmailTask::class)->run($unverifiedUser);

        Notification::assertNotSentTo($unverifiedUser, VerifyEmail::class);
    }
}
