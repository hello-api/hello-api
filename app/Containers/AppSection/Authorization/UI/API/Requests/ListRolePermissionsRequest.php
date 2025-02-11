<?php

namespace App\Containers\AppSection\Authorization\UI\API\Requests;

use App\Containers\AppSection\Authorization\Models\Permission;
use App\Ship\Parents\Requests\Request as ParentRequest;

class ListRolePermissionsRequest extends ParentRequest
{
    protected array $decode = [
        'role_id',
    ];

    public function rules(): array
    {
        return [];
    }

    public function authorize(): bool
    {
        return $this->user()->can('viewAny', Permission::class);
    }
}
