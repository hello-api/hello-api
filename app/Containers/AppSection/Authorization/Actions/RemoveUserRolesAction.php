<?php

namespace App\Containers\AppSection\Authorization\Actions;

use App\Containers\AppSection\Authorization\UI\API\Requests\RemoveUserRolesRequest;
use App\Containers\AppSection\User\Models\User;
use App\Containers\AppSection\User\Tasks\FindUserByIdTask;
use App\Ship\Exceptions\ResourceNotFound;
use App\Ship\Parents\Actions\Action as ParentAction;

class RemoveUserRolesAction extends ParentAction
{
    public function __construct(
        private readonly FindUserByIdTask $findUserByIdTask,
    ) {
    }

    /**
     * @throws ResourceNotFound
     */
    public function run(RemoveUserRolesRequest $request): User
    {
        $user = $this->findUserByIdTask->run($request->user_id);

        foreach ($request->role_ids as $role_id) {
            $user->removeRole($role_id);
        }

        return $user;
    }
}
