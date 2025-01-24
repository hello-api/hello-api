<?php

namespace App\Containers\AppSection\User\Tasks;

use App\Containers\AppSection\User\Data\Repositories\UserRepository;
use App\Containers\AppSection\User\Models\User;
use App\Ship\Exceptions\CreateResourceFailed;
use App\Ship\Parents\Tasks\Task as ParentTask;

class CreateUserTask extends ParentTask
{
    public function __construct(
        private readonly UserRepository $repository,
    ) {
    }

    /**
     * @throws CreateResourceFailed
     */
    public function run(array $data): User
    {
        try {
            $user = $this->repository->create($data);
        } catch (\Exception) {
            throw CreateResourceFailed::create('User');
        }

        return $user;
    }
}
