<?php

namespace App\Containers\AppSection\Authentication\Actions;

use App\Containers\AppSection\Authentication\Exceptions\InvalidEmailVerificationData;
use App\Containers\AppSection\Authentication\Notifications\EmailVerified;
use App\Containers\AppSection\Authentication\UI\API\Requests\VerifyEmailRequest;
use App\Containers\AppSection\User\Models\User;
use App\Containers\AppSection\User\Tasks\FindUserByIdTask;
use App\Ship\Exceptions\ResourceNotFound;
use App\Ship\Parents\Actions\Action as ParentAction;
use App\Ship\Parents\Requests\Request;

class VerifyEmailAction extends ParentAction
{
    public function __construct(
        private readonly FindUserByIdTask $findUserByIdTask,
    ) {
    }

    /**
     * @throws ResourceNotFound
     * @throws \Throwable
     */
    public function run(VerifyEmailRequest $request): void
    {
        $user = $this->findUserByIdTask->run($request->user_id);

        throw_unless($this->emailIsValid($request, $user), InvalidEmailVerificationData::create());

        if (!$user->hasVerifiedEmail()) {
            $user->markEmailAsVerified();

            $user->notify(new EmailVerified());
        }
    }

    private function emailIsValid(Request $request, User $user): bool
    {
        return hash_equals((string) $request->hash, sha1($user->getEmailForVerification()));
    }
}
