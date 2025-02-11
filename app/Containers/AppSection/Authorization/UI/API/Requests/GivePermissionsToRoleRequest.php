<?php

namespace App\Containers\AppSection\Authorization\UI\API\Requests;

use App\Containers\AppSection\Authorization\Models\Permission;
use App\Ship\Parents\Requests\Request as ParentRequest;

class GivePermissionsToRoleRequest extends ParentRequest
{
    protected array $decode = [
        'role_id',
        'permission_ids.*',
    ];

    public function rules(): array
    {
        return [
            'role_id' => 'exists:roles,id',
            'permission_ids' => 'array|required',
            'permission_ids.*' => 'exists:permissions,id',
        ];
    }

    public function authorize(): bool
    {
        return $this->user()->can('give', Permission::class);
    }
}
