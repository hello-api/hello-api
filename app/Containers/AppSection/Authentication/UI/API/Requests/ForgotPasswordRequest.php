<?php

namespace App\Containers\AppSection\Authentication\UI\API\Requests;

use App\Ship\Parents\Requests\Request as ParentRequest;
use Illuminate\Validation\Rule;

class ForgotPasswordRequest extends ParentRequest
{
    protected array $decode = [];

    public function rules(): array
    {
        return [
            'email' => 'required|email',
            'reseturl' => [
                'required',
                Rule::in(config('appSection-authentication.allowed-reset-password-urls')),
            ],
        ];
    }
}
