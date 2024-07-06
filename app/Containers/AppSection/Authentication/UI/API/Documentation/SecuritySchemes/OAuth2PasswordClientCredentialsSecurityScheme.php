<?php

namespace App\Containers\AppSection\Authentication\UI\API\Documentation\SecuritySchemes;

use App\Ship\Documentation\Collections\PrivateCollection;
use GoldSpecDigital\ObjectOrientedOAS\Objects\OAuthFlow;
use GoldSpecDigital\ObjectOrientedOAS\Objects\SecurityScheme;
use MohammadAlavi\LaravelOpenApi\Attributes\Collection;
use MohammadAlavi\LaravelOpenApi\Factories\SecuritySchemeFactory;

#[Collection([PrivateCollection::class])]
class OAuth2PasswordClientCredentialsSecurityScheme extends SecuritySchemeFactory
{
    public function build(): SecurityScheme
    {
        return SecurityScheme::create('OAuth2PasswordClientCredentials')
            ->type(SecurityScheme::TYPE_OAUTH2)
            ->flows(
                OAuthFlow::create()
                    ->flow('password')
                    ->authorizationUrl(env('APP_URL') . '/oauth2/authorize')
                    ->tokenUrl(env('APP_URL') . '/oauth2/grants/password/token')
                    ->refreshUrl(env('APP_URL') . '/oauth2/refresh')
                    ->scopes([
                        'read' => 'Read access',
                        'write' => 'Write access',
                    ])
            );
    }
}
