<?php

namespace App\Containers\AppSection\User\Actions;

use App\Containers\AppSection\User\Data\Repositories\UserRepository;
use App\Containers\AppSection\User\Exceptions\FailedToDeleteUser;
use App\Containers\AppSection\User\UI\API\Requests\DeleteUserRequest;
use App\Ship\Exceptions\ResourceNotFound;
use App\Ship\Parents\Actions\Action as ParentAction;

class DeleteUserAction extends ParentAction
{
    public function __construct(
        private readonly UserRepository $repository,
    ) {
    }

    /**
     * @throws FailedToDeleteUser
     * @throws ResourceNotFound
     */
    public function run(DeleteUserRequest $request): bool
    {
        $user = $this->repository->findById($request->user_id);

        if ($request->user()->is($user)) {
            throw FailedToDeleteUser::becauseCannotDeleteItself();
        }

        return $this->repository->delete($request->user_id);
    }
}
