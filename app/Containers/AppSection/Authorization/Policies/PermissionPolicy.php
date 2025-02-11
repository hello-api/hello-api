<?php

namespace App\Containers\AppSection\Authorization\Policies;

use App\Containers\AppSection\User\Models\User;
use App\Ship\Parents\Policies\Policy as ParentPolicy;

final class PermissionPolicy extends ParentPolicy
{
    public function give(User $user): bool
    {
        return $user->isSuperAdmin();
    }

    public function view(User $user): bool
    {
        return $user->isSuperAdmin();
    }

    public function viewAny(User $user): bool
    {
        return $user->isSuperAdmin();
    }

    public function revoke(User $user): bool
    {
        return $user->isSuperAdmin();
    }

    public function sync(User $user): bool
    {
        return $user->isSuperAdmin();
    }
}
