<?php

namespace App\Containers\AppSection\Authentication\UI\API\Requests;

use App\Containers\AppSection\Authentication\Classes\LoginFieldParser;
use App\Ship\Parents\Requests\Request as ParentRequest;

class LoginProxyPasswordGrantRequest extends ParentRequest
{
    protected array $decode = [];

    public function rules(): array
    {
        $rules = [
            // We don't need to require email here.
            // The proper login field (with proper validations)
            // will be added automatically by "mergeValidationRules" method below
            // 'email' => 'required',
            'password' => 'required',
        ];

        return LoginFieldParser::mergeValidationRules($rules);
    }
}
