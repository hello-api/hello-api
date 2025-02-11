<?php

namespace App\Containers\AppSection\Authorization\Models;

use Apiato\Abstract\Models\ApiatoIntegration;
use Apiato\Http\Resources\ResourceKeyAware;
use App\Containers\AppSection\Authorization\Data\Collections\RoleCollection;
use Spatie\Permission\Models\Role as SpatieRole;

class Role extends SpatieRole implements ResourceKeyAware
{
    use ApiatoIntegration;

    protected $fillable = [
        'name',
        'guard_name',
        'display_name',
        'description',
    ];

    public function newCollection(array $models = []): RoleCollection
    {
        return new RoleCollection($models);
    }
}
