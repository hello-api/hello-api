<?php

namespace App\Containers\AppSection\Authorization\UI\API\Requests;

use App\Containers\AppSection\Authorization\Models\Role;
use App\Ship\Parents\Requests\Request as ParentRequest;

class DeleteRoleRequest extends ParentRequest
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
        return $this->user()->can('delete', Role::class);
    }
}
