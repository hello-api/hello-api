<?php

namespace App\Containers\AppSection\User\Tasks;

use App\Containers\AppSection\User\Data\Repositories\UserRepository;
use App\Containers\AppSection\User\Models\User;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Parents\Tasks\Task as ParentTask;

class FindUserByIdTask extends ParentTask
{
    public function __construct(
        protected readonly UserRepository $repository
    ) {
    }

    /**
     * @throws NotFoundException
     */
    public function run($userId): User
    {
        try {
            return $this->repository->find($userId);
        } catch (\Exception) {
            throw new NotFoundException();
        }
    }
}
