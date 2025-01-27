<?php

namespace App\Containers\AppSection\Authentication\Actions;

use Apiato\Exceptions\IncorrectId;
use App\Containers\AppSection\Authentication\Mails\ForgotPassword;
use App\Containers\AppSection\Authentication\Tasks\CreatePasswordResetTokenTask;
use App\Containers\AppSection\Authentication\UI\API\Requests\ForgotPasswordRequest;
use App\Containers\AppSection\User\Tasks\FindUserByEmailTask;
use App\Ship\Parents\Actions\Action as ParentAction;
use Illuminate\Support\Facades\Mail;

class ForgotPasswordAction extends ParentAction
{
    public function __construct(
        private readonly FindUserByEmailTask $findUserByEmailTask,
        private readonly CreatePasswordResetTokenTask $createPasswordResetTokenTask,
    ) {
    }

    /**
     * @throws IncorrectId
     */
    public function run(ForgotPasswordRequest $request): bool
    {
        $sanitizedData = $request->sanitizeInput([
            'email',
            'reseturl',
        ]);

        // To prevent email enumeration we always return true even if the user does not exist,
        // So the client can't tell if the user exists or not based on the response
        try {
            $user = $this->findUserByEmailTask->run($sanitizedData['email']);
            $token = $this->createPasswordResetTokenTask->run($user);
            Mail::send(new ForgotPassword($user, $token, $sanitizedData['reseturl']));
        } catch (\Throwable) {
            return true;
        }

        return true;
    }
}
