<?php

namespace App\Containers\AppSection\User\UI\API\Requests;

use App\Containers\AppSection\User\Models\User;
use App\Ship\Parents\Requests\Request as ParentRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class UpdatePasswordRequest extends ParentRequest
{
    protected array $decode = [
        'user_id',
    ];

    public function rules(): array
    {
        return [
            'current_password' => [
                Rule::requiredIf(fn (): bool => !is_null($this->user()->password)),
                'current_password:api',
            ],
            'new_password' => [
                'required',
                Password::default(),
            ],
            'new_password_confirmation' => 'required_with:new_password|same:new_password',
        ];
    }

    public function authorize(): bool
    {
        return $this->user()->can('update', [User::class, $this->user_id]);
    }
}
