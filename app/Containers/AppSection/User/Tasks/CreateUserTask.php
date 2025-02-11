<?php

namespace App\Containers\AppSection\User\Tasks;

use App\Containers\AppSection\User\Data\Repositories\UserRepository;
use App\Containers\AppSection\User\Models\User;
use App\Ship\Exceptions\ResourceCreationFailed;
use App\Ship\Parents\Tasks\Task as ParentTask;

class CreateUserTask extends ParentTask
{
    public function __construct(
        private readonly UserRepository $repository,
    ) {
    }

    /**
     * @throws ResourceCreationFailed
     */
    public function run(array $data): User
    {
        try {
            $user = $this->repository->create($data);
        } catch (\Exception) {
            throw ResourceCreationFailed::create('User');
        }

        return $user;
    }
}
