<?php

namespace App\Containers\AppSection\Authentication\Actions;

use App\Containers\AppSection\Authentication\Notifications\Welcome;
use App\Containers\AppSection\Authentication\Tasks\SendVerificationEmailTask;
use App\Containers\AppSection\Authentication\UI\API\Requests\RegisterUserRequest;
use App\Containers\AppSection\User\Models\User;
use App\Containers\AppSection\User\Tasks\CreateUserTask;
use App\Ship\Exceptions\ResourceCreationFailed;
use App\Ship\Parents\Actions\Action as ParentAction;

class RegisterUserAction extends ParentAction
{
    public function __construct(
        private readonly CreateUserTask $createUserTask,
        private readonly SendVerificationEmailTask $sendVerificationEmailTask,
    ) {
    }

    /**
     * @throws ResourceCreationFailed
     */
    public function run(RegisterUserRequest $request): User
    {
        $sanitizedData = $request->sanitize([
            'email',
            'password',
            'name',
            'gender',
            'birth',
        ]);

        $user = $this->createUserTask->run($sanitizedData);

        $user->notify(new Welcome());
        $this->sendVerificationEmailTask->run($user, $request->verification_url);

        return $user;
    }
}
