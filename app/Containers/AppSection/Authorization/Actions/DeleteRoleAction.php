<?php

namespace App\Containers\AppSection\Authorization\Actions;

use App\Containers\AppSection\Authorization\Data\Repositories\RoleRepository;
use App\Containers\AppSection\Authorization\UI\API\Requests\DeleteRoleRequest;
use App\Ship\Exceptions\ResourceNotFound;
use App\Ship\Parents\Actions\Action as ParentAction;

class DeleteRoleAction extends ParentAction
{
    public function __construct(
        private readonly RoleRepository $repository,
    ) {
    }

    /**
     * @throws ResourceNotFound
     */
    public function run(DeleteRoleRequest $request): bool
    {
        return $this->repository->delete($request->role_id);
    }
}
