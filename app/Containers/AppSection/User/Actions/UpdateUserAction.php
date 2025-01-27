<?php

namespace App\Containers\AppSection\User\Actions;

use Apiato\Exceptions\IncorrectId;
use App\Containers\AppSection\User\Models\User;
use App\Containers\AppSection\User\Tasks\UpdateUserTask;
use App\Containers\AppSection\User\UI\API\Requests\UpdateUserRequest;
use App\Ship\Exceptions\ResourceNotFound;
use App\Ship\Parents\Actions\Action as ParentAction;
use Prettus\Validator\Exceptions\ValidatorException;

class UpdateUserAction extends ParentAction
{
    public function __construct(
        private readonly UpdateUserTask $updateUserTask,
    ) {
    }

    /**
     * @throws ResourceNotFound
     * @throws IncorrectId
     * @throws ValidatorException
     */
    public function run(UpdateUserRequest $request): User
    {
        $sanitizedData = $request->sanitizeInput([
            'name',
            'gender',
            'birth',
            'password',
        ]);

        return $this->updateUserTask->run($request->user_id, $sanitizedData);
    }
}
