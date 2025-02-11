<?php

namespace App\Containers\AppSection\User\Actions;

use App\Containers\AppSection\User\Models\User;
use App\Containers\AppSection\User\Notifications\PasswordUpdatedNotification;
use App\Containers\AppSection\User\Tasks\UpdateUserTask;
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
     * @throws ResourceNotFound
     * @throws ValidatorException
     */
    public function run(int $userId, string $password): User
    {
        $user = $this->updateUserTask->run($userId, ['password' => $password]);

        $user->notify(new PasswordUpdatedNotification());

        return $user;
    }
}
