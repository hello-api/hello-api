<?php

namespace App\Containers\AppSection\Authentication\UI\API\Requests;

use App\Ship\Parents\Requests\Request as ParentRequest;
use Illuminate\Validation\Rule;

class SendVerificationEmailRequest extends ParentRequest
{
    protected array $decode = [];

    public function rules(): array
    {
        return [
            'verification_url' => [
                'required',
                'url',
                Rule::in(config('appSection-authentication.allowed-verify-email-urls')),
            ],
        ];
    }
}
