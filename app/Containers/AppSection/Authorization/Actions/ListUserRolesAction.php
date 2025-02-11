<?php

namespace App\Containers\AppSection\Authorization\Actions;

use App\Containers\AppSection\Authorization\UI\API\Requests\ListUserRolesRequest;
use App\Containers\AppSection\User\Tasks\FindUserByIdTask;
use App\Ship\Exceptions\ResourceNotFound;
use App\Ship\Parents\Actions\Action as ParentAction;
use Illuminate\Database\Eloquent\Collection;
use Spatie\Permission\Contracts\Role;

class ListUserRolesAction extends ParentAction
{
    public function __construct(
        private readonly FindUserByIdTask $findUserByIdTask,
    ) {
    }

    /**
     * @return Collection<array-key, Role>
     *
     * @throws ResourceNotFound
     */
    public function run(ListUserRolesRequest $request): Collection
    {
        return $this->findUserByIdTask->run($request->user_id)->roles;
    }
}
