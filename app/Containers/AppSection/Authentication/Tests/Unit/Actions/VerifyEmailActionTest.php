<?php

namespace App\Containers\AppSection\Authentication\Tests\Unit\Actions;

use App\Containers\AppSection\Authentication\Actions\VerifyEmailAction;
use App\Containers\AppSection\Authentication\Exceptions\InvalidEmailVerificationData;
use App\Containers\AppSection\Authentication\Notifications\EmailVerified;
use App\Containers\AppSection\Authentication\Tests\UnitTestCase;
use App\Containers\AppSection\Authentication\UI\API\Requests\VerifyEmailRequest;
use App\Containers\AppSection\User\Models\User;
use Illuminate\Support\Facades\Notification;
use PHPUnit\Framework\Attributes\CoversClass;

#[CoversClass(VerifyEmailAction::class)]
final class VerifyEmailActionTest extends UnitTestCase
{
    public function testVerifyEmail(): void
    {
        Notification::fake();
        $user = User::factory()->unverified()->createOne();
        $action = app(VerifyEmailAction::class);
        $request = VerifyEmailRequest::injectData([
            'hash' => sha1($user->email),
        ])->withUrlParameters([
            'user_id' => $user->id,
        ]);

        $action->run($request);

        $this->assertTrue($user->refresh()->hasVerifiedEmail());
        Notification::assertSentTo($user, EmailVerified::class);
    }

    public function testGivenEmailMismatchedShouldThrowProperException(): void
    {
        $this->expectException(InvalidEmailVerificationData::class);

        $user = User::factory()->unverified()->createOne();
        $action = app(VerifyEmailAction::class);
        $request = VerifyEmailRequest::injectData([
            'hash' => sha1('nonematching@email.com'),
        ])->withUrlParameters([
            'user_id' => $user->id,
        ]);

        $action->run($request);
    }
}
