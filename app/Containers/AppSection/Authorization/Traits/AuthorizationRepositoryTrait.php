<?php

namespace App\Containers\AppSection\Authorization\Traits;

use App\Containers\AppSection\Authorization\Data\Criterias\WhereGuardCriteria;
use Illuminate\Contracts\Container\BindingResolutionException;
use Prettus\Repository\Exceptions\RepositoryException;

// TODO
trait AuthorizationRepositoryTrait
{
    /**
     * @throws RepositoryException
     * @throws BindingResolutionException
     */
    public function whereGuard(string|null $guard): static
    {
        if (null !== $guard) {
            $this->pushCriteriaWith(WhereGuardCriteria::class, compact('guard'));
        }

        return $this;
    }
}
