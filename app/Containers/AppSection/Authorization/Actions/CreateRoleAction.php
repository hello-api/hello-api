<?php

namespace App\Containers\AppSection\Authorization\Actions;

use App\Containers\AppSection\Authorization\Models\Role;
use App\Containers\AppSection\Authorization\Tasks\CreateRoleTask;
use App\Containers\AppSection\Authorization\UI\API\Requests\CreateRoleRequest;
use App\Ship\Exceptions\ResourceCreationFailed;
use App\Ship\Parents\Actions\Action as ParentAction;

class CreateRoleAction extends ParentAction
{
    public function __construct(
        private readonly CreateRoleTask $createRoleTask,
    ) {
    }

    /**
     * @throws ResourceCreationFailed
     */
    public function run(CreateRoleRequest $request): Role
    {
        return $this->createRoleTask->run($request->name, $request->description, $request->display_name);
    }
}
