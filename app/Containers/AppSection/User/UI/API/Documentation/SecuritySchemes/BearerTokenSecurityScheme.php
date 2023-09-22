<?php

namespace App\Containers\AppSection\User\UI\API\Documentation\SecuritySchemes;

use GoldSpecDigital\ObjectOrientedOAS\Objects\SecurityScheme;
use Vyuldashev\LaravelOpenApi\Attributes\Collection;
use Vyuldashev\LaravelOpenApi\Factories\SecuritySchemeFactory;

#[Collection(name: ['private', 'public'])]
class BearerTokenSecurityScheme extends SecuritySchemeFactory
{
    public function build(): SecurityScheme
    {
        return SecurityScheme::create('BearerToken')
            ->type(SecurityScheme::TYPE_HTTP)
            ->scheme('bearer');
    }
}
