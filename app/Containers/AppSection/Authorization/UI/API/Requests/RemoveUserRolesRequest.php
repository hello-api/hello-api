<?php

namespace App\Containers\AppSection\Authorization\UI\API\Requests;

use App\Containers\AppSection\Authorization\Models\Role;
use App\Ship\Parents\Requests\Request as ParentRequest;

class RemoveUserRolesRequest extends ParentRequest
{
    protected array $decode = [
        'user_id',
        'role_ids.*',
    ];

    public function rules(): array
    {
        return [
            'user_id' => 'exists:users,id',
            'role_ids' => 'array|required',
            'role_ids.*' => 'required|exists:roles,id',
        ];
    }

    public function authorize(): bool
    {
        return $this->user()->can('revoke', Role::class);
    }
}
