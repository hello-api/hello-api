<?php

namespace App\Containers\AppSection\Authorization\UI\API\Requests;

use App\Containers\AppSection\Authorization\Models\Role;
use App\Ship\Parents\Requests\Request as ParentRequest;

class CreateRoleRequest extends ParentRequest
{
    protected array $decode = [];

    public function rules(): array
    {
        return [
            'name' => 'required|unique:' . config('permission.table_names.roles') . ',name|min:2|max:20|alpha',
            'description' => 'max:255',
            'display_name' => 'max:100',
        ];
    }

    public function authorize(): bool
    {
        return $this->user()->can('create', Role::class);
    }
}
