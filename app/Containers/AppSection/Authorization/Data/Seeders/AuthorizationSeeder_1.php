<?php

namespace App\Containers\AppSection\Authorization\Data\Seeders;

use App\Containers\AppSection\Authorization\Enums\Role;
use App\Containers\AppSection\Authorization\Tasks\CreateRoleTask;
use App\Ship\Parents\Seeders\Seeder as ParentSeeder;

class AuthorizationSeeder_1 extends ParentSeeder
{
    public function run(CreateRoleTask $task): void
    {
        foreach (array_keys(config('auth.guards')) as $guardName) {
            $task->run(
                Role::SUPER_ADMIN->value,
                'Administrator',
                Role::SUPER_ADMIN->label(),
                $guardName,
            );
        }
    }
}
