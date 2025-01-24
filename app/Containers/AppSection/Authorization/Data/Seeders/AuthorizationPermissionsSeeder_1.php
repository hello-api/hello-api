<?php

namespace App\Containers\AppSection\Authorization\Data\Seeders;

use App\Containers\AppSection\Authorization\Tasks\CreatePermissionTask;
use App\Ship\Exceptions\CreateResourceFailed;
use App\Ship\Parents\Seeders\Seeder as ParentSeeder;

class AuthorizationPermissionsSeeder_1 extends ParentSeeder
{
    /**
     * @throws CreateResourceFailed
     */
    public function run(CreatePermissionTask $task): void
    {
        // Default Permissions for every Guard ----------------------------------------------------------
        foreach (array_keys(config('auth.guards')) as $guardName) {
            $task->run('manage-roles', 'Create, Update, Delete, Get All, Attach/detach permissions to Roles and Get All Permissions.', guardName: $guardName);
            $task->run('manage-permissions', 'Create, Update, Delete, Get All, Attach/detach permissions to User.', guardName: $guardName);
            $task->run('create-admins', 'Create new Users (Admins) from the dashboard.', guardName: $guardName);
            $task->run('manage-admins-access', 'Assign users to Roles.', guardName: $guardName);
            $task->run('access-dashboard', 'Access the admins dashboard.', guardName: $guardName);
        }
    }
}
