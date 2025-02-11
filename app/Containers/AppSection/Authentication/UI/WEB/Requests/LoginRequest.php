<?php

namespace App\Containers\AppSection\Authentication\UI\WEB\Requests;

use App\Containers\AppSection\Authentication\Classes\LoginFieldParser;
use App\Ship\Parents\Requests\Request as ParentRequest;

class LoginRequest extends ParentRequest
{
    protected array $decode = [];

    public function rules(): array
    {
        $rules = [
            'password' => 'required',
            'remember' => 'boolean',
        ];

        return LoginFieldParser::mergeValidationRules($rules);
    }
}
