<?php

namespace App\Containers\AppSection\Authentication\UI\API\Requests;

use App\Ship\Parents\Requests\Request as ParentRequest;

class RefreshProxyRequest extends ParentRequest
{
    protected array $decode = [];

    public function rules(): array
    {
        return [
            'refresh_token' => 'string',
        ];
    }
}
