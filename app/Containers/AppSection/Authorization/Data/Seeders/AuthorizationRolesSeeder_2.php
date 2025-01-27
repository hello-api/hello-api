<?php

namespace App\Containers\AppSection\Authorization\Data\Seeders;

use App\Containers\AppSection\Authorization\Tasks\CreateRoleTask;
use App\Ship\Exceptions\CreateResourceFailed;
use App\Ship\Parents\Seeders\Seeder as ParentSeeder;

class AuthorizationRolesSeeder_2 extends ParentSeeder
{
    /**
     * @throws CreateResourceFailed
     */
    public function run(CreateRoleTask $task): void
    {
        // Default Roles for every Guard ----------------------------------------------------------------
        foreach (array_keys(config('auth.guards')) as $guardName) {
            $task->run(config('appSection-authorization.admin_role'), 'Administrator', 'Administrator Role', $guardName);
        }
    }
}
