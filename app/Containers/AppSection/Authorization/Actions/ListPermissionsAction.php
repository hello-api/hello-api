<?php

namespace App\Containers\AppSection\Authorization\Actions;

use App\Containers\AppSection\Authorization\Data\Collections\PermissionCollection;
use App\Containers\AppSection\Authorization\Data\Repositories\PermissionRepository;
use App\Ship\Parents\Actions\Action as ParentAction;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Pagination\LengthAwarePaginator;
use Prettus\Repository\Exceptions\RepositoryException;

class ListPermissionsAction extends ParentAction
{
    public function __construct(
        private readonly PermissionRepository $repository,
    ) {
    }

    /**
     * @throws RepositoryException
     * @throws BindingResolutionException
     */
    public function run(): LengthAwarePaginator|PermissionCollection
    {
        $this->repository->addRequestCriteria();
        $this->repository->whereGuard(activeGuard());

        return $this->repository->paginate();
    }
}
