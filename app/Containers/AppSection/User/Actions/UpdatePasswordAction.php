<?php

namespace App\Containers\AppSection\User\Actions;

use Apiato\Exceptions\IncorrectId;
use App\Containers\AppSection\User\Models\User;
use App\Containers\AppSection\User\Notifications\PasswordUpdatedNotification;
use App\Containers\AppSection\User\Tasks\UpdateUserTask;
use App\Containers\AppSection\User\UI\API\Requests\UpdatePasswordRequest;
use App\Ship\Exceptions\ResourceNotFound;
use App\Ship\Parents\Actions\Action as ParentAction;
use Prettus\Validator\Exceptions\ValidatorException;

class UpdatePasswordAction extends ParentAction
{
    public function __construct(
        private readonly UpdateUserTask $updateUserTask,
    ) {
    }

    /**
     * @throws IncorrectId
     * @throws ResourceNotFound
     * @throws ValidatorException
     */
    public function run(UpdatePasswordRequest $request): User
    {
        $sanitizedData = $request->sanitizeInput([
            'password',
        ]);

        $user = $this->updateUserTask->run($request->user_id, $sanitizedData);

        $user->notify(new PasswordUpdatedNotification());

        return $user;
    }
}
