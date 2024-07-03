<?php

namespace App\Containers\AppSection\Authorization\Tasks;

use App\Containers\AppSection\Authorization\Data\Repositories\PermissionRepository;
use App\Containers\AppSection\Authorization\Models\Permission;
use App\Ship\Exceptions\CreateResourceFailedException;
use App\Ship\Parents\Tasks\Task as ParentTask;

class CreatePermissionTask extends ParentTask
{
    public function __construct(
        protected readonly PermissionRepository $repository
    ) {
    }

    /**
     * @throws CreateResourceFailedException
     */
    public function run(string $name, ?string $description = null, ?string $displayName = null, string $guardName = 'api'): Permission
    {
        try {
            $permission = $this->repository->create([
                'name' => strtolower($name),
                'description' => $description,
                'display_name' => $displayName,
                'guard_name' => $guardName,
            ]);
        } catch (\Exception $exception) {
            throw new CreateResourceFailedException($exception->getMessage());
        }

        return $permission;
    }
}
