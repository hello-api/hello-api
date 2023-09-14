<?php

namespace App\Containers\AppSection\Documentation\Traits;

use Apiato\Core\Abstracts\Models\UserModel;
use Illuminate\Support\Facades\Auth;

trait HasDocAccessTrait
{
    /**
     * Check if the authenticated user has proper
     * roles/permissions to access the private docs.
     */
    public function hasDocAccess(): bool
    {
        if ($this->docsAreProtected()) {
            $user = Auth::user();

            return $this->userExists($user) && $this->isAuthorized($user);
        }

        return true;
    }

    private function docsAreProtected()
    {
        return config('documentation.protect-private-docs');
    }

    private function userExists($user): bool
    {
        return !is_null($user);
    }

    private function isAuthorized(UserModel $user): bool
    {
        return $this->hasRolesWithAccess($user) || $this->hasPermission($user);
    }

    private function hasRolesWithAccess(UserModel $user): bool
    {
        if (is_callable([$user, 'hasRole'])) {
            return $user->hasRole(config('documentation.access-private-docs-roles'), 'web');
        }

        return true;
    }

    private function hasPermission($user)
    {
        if (is_callable([$user, 'checkPermissionTo'])) {
            return $user->checkPermissionTo(config('documentation.access-private-docs-permission'), 'web');
        }

        return true;
    }
}
