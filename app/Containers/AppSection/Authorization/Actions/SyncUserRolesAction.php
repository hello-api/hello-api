<?php

namespace App\Containers\AppSection\Authorization\Actions;

use App\Containers\AppSection\Authorization\UI\API\Requests\SyncUserRolesRequest;
use App\Containers\AppSection\User\Models\User;
use App\Containers\AppSection\User\Tasks\FindUserByIdTask;
use App\Ship\Exceptions\ResourceNotFound;
use App\Ship\Parents\Actions\Action as ParentAction;

class SyncUserRolesAction extends ParentAction
{
    public function __construct(
        private readonly FindUserByIdTask $findUserByIdTask,
    ) {
    }

    /**
     * @throws ResourceNotFound
     */
    public function run(SyncUserRolesRequest $request): User
    {
        return $this->findUserByIdTask->run($request->user_id)
            ->syncRoles($request->role_ids);
    }
}
