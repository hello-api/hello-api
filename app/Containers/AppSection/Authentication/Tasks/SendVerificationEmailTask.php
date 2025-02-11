<?php

namespace App\Containers\AppSection\Authentication\Tasks;

use App\Ship\Contracts\MustVerifyEmail;
use App\Ship\Parents\Tasks\Task as ParentTask;

// TODO
class SendVerificationEmailTask extends ParentTask
{
    public function run(MustVerifyEmail $user, string|null $verificationUrl = null): void
    {
        if (null !== $verificationUrl && config('appSection-authentication.require_email_verification') && !$user->hasVerifiedEmail()) {
            $user->sendEmailVerificationNotificationWithVerificationUrl($verificationUrl);
        }
    }
}
