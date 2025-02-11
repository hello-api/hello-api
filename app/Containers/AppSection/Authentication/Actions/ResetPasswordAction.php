<?php

namespace App\Containers\AppSection\Authentication\Actions;

use App\Containers\AppSection\Authentication\Exceptions\InvalidResetPasswordToken;
use App\Containers\AppSection\Authentication\Notifications\PasswordReset;
use App\Containers\AppSection\Authentication\UI\API\Requests\ResetPasswordRequest;
use App\Containers\AppSection\User\Tasks\FindUserByEmailTask;
use App\Ship\Exceptions\ResourceNotFound;
use App\Ship\Parents\Actions\Action as ParentAction;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

class ResetPasswordAction extends ParentAction
{
    public function __construct(
        private readonly FindUserByEmailTask $findUserByEmailTask,
    ) {
    }

    /**
     * @throws InvalidResetPasswordToken
     * @throws ResourceNotFound
     */
    public function run(ResetPasswordRequest $request): void
    {
        $sanitizedData = $request->sanitize([
            'email',
            'token',
            'password',
            'password_confirmation' => $request->password,
        ]);

        $status = Password::broker()->reset(
            $sanitizedData,
            static function ($user, $password) {
                $user->forceFill(compact('password'))
                    ->setRememberToken(Str::random(60));
                $user->save();
            },
        );

        switch ($status) {
            case Password::INVALID_TOKEN:
                throw InvalidResetPasswordToken::create();
            case Password::INVALID_USER:
                throw ResourceNotFound::create('User');
            default:
                $user = $this->findUserByEmailTask->run($sanitizedData['email']);
                $user->notify(new PasswordReset());
        }
    }
}
