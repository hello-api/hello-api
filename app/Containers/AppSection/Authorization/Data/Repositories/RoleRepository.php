<?php

namespace App\Containers\AppSection\Authorization\Data\Repositories;

use App\Containers\AppSection\Authorization\Enums\Role as RoleEnum;
use App\Containers\AppSection\Authorization\Models\Role;
use App\Containers\AppSection\Authorization\Traits\AuthorizationRepositoryTrait;
use App\Containers\AppSection\User\Models\User;
use App\Ship\Parents\Repositories\Repository as ParentRepository;

/**
 * @template TModel of Role
 *
 * @extends ParentRepository<TModel>
 */
class RoleRepository extends ParentRepository
{
    use AuthorizationRepositoryTrait;

    protected $fieldSearchable = [
        'name' => '=',
        'display_name' => 'like',
        'description' => 'like',
    ];

    public function model(): string
    {
        return config('permission.models.role');
    }

    public function isSuperAdmin(User $user): bool
    {
        return $user->hasRole(RoleEnum::SUPER_ADMIN);
    }
}
