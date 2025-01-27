<?php

namespace App\Containers\AppSection\Authorization\Tasks;

use App\Containers\AppSection\Authorization\Data\Repositories\RoleRepository;
use App\Containers\AppSection\Authorization\Models\Role;
use App\Ship\Exceptions\CreateResourceFailed;
use App\Ship\Parents\Tasks\Task as ParentTask;

class CreateRoleTask extends ParentTask
{
    public function __construct(
        private readonly RoleRepository $repository,
    ) {
    }

    /**
     * @throws CreateResourceFailed
     */
    public function run(string $name, string|null $description = null, string|null $displayName = null, string $guardName = 'api'): Role
    {
        try {
            $role = $this->repository->create([
                'name' => strtolower($name),
                'description' => $description,
                'display_name' => $displayName,
                'guard_name' => $guardName,
            ]);
        } catch (\Exception) {
            throw CreateResourceFailed::create('Role');
        }

        return $role;
    }
}
