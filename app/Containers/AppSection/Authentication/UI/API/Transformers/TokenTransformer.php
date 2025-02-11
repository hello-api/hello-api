<?php

namespace App\Containers\AppSection\Authentication\UI\API\Transformers;

use App\Containers\AppSection\Authentication\DataTransferObjects\Token;
use App\Ship\Parents\Transformers\Transformer as ParentTransformer;

final class TokenTransformer extends ParentTransformer
{
    public function transform(Token $token): array
    {
        return [
            'object' => $token->getResourceKey(),
            'token_type' => $token->tokenType,
            'access_token' => $token->accessToken,
            'refresh_token' => $token->refreshToken,
            'expires_in' => $token->expiresIn,
        ];
    }
}
