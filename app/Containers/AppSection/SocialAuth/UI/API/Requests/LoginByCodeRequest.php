<?php

namespace App\Containers\AppSection\SocialAuth\UI\API\Requests;

use Apiato\Core\Abstracts\Requests\Request;

final class LoginByCodeRequest extends Request
{
    public function rules(): array
    {
        return [
            'code' => ['required', 'string'],
        ];
    }
}