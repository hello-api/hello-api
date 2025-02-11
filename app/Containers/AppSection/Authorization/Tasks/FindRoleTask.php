<?php

namespace App\Containers\AppSection\Authorization\Tasks;

use App\Containers\AppSection\Authorization\Data\Repositories\RoleRepository;
use App\Containers\AppSection\Authorization\Models\Role;
use App\Ship\Exceptions\ResourceNotFound;
use App\Ship\Parents\Tasks\Task as ParentTask;
use Illuminate\Support\Str;

class FindRoleTask extends ParentTask
{
    public function __construct(
        private readonly RoleRepository $repository,
    ) {
    }

    /**
     * @throws ResourceNotFound
     */
    public function run(string|int $roleNameOrId, string $guardName = 'api'): Role
    {
        $query = [
            'guard_name' => $guardName,
        ];

        if ($this->isId($roleNameOrId)) {
            $query['id'] = $roleNameOrId;
        } else {
            $query['name'] = $roleNameOrId;
        }

        return $this->repository->findWhere($query)->first() ?? throw ResourceNotFound::create('Role');
    }

    private function isId(int|string $roleNameOrId): bool
    {
        return is_numeric($roleNameOrId) || Str::isUuid($roleNameOrId) || Str::isUlid($roleNameOrId);
    }
}
