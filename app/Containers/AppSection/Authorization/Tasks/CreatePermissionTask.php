<?php

namespace App\Containers\AppSection\Authorization\Tasks;

use App\Containers\AppSection\Authorization\Data\Repositories\PermissionRepository;
use App\Containers\AppSection\Authorization\Models\Permission;
use App\Ship\Exceptions\CreateResourceFailed;
use App\Ship\Parents\Tasks\Task as ParentTask;

class CreatePermissionTask extends ParentTask
{
    public function __construct(
        private readonly PermissionRepository $repository,
    ) {
    }

    /**
     * @throws CreateResourceFailed
     */
    public function run(string $name, string|null $description = null, string|null $displayName = null, string $guardName = 'api'): Permission
    {
        try {
            $permission = $this->repository->create([
                'name' => strtolower($name),
                'description' => $description,
                'display_name' => $displayName,
                'guard_name' => $guardName,
            ]);
        } catch (\Exception) {
            throw CreateResourceFailed::create('Permission');
        }

        return $permission;
    }
}
