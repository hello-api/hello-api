<?php

namespace App\Containers\AppSection\User\Tasks;

use App\Containers\AppSection\User\Data\Repositories\UserRepository;
use App\Containers\AppSection\User\Models\User;
use App\Ship\Exceptions\ResourceNotFound;
use App\Ship\Parents\Tasks\Task as ParentTask;

class FindUserByEmailTask extends ParentTask
{
    public function __construct(
        private readonly UserRepository $repository,
    ) {
    }

    /**
     * @throws ResourceNotFound
     */
    public function run(string $email): User
    {
        $user = $this->repository->findByField('email', $email)->first();

        return $user ?? throw ResourceNotFound::create('User');
    }
}
