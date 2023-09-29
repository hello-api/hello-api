<?php

namespace App\Containers\AppSection\User\UI\API\Documentation\SecuritySchemes;

use GoldSpecDigital\ObjectOrientedOAS\Objects\SecurityScheme;
use Vyuldashev\LaravelOpenApi\Attributes\Collection;
use Vyuldashev\LaravelOpenApi\Factories\SecuritySchemeFactory;

// Means: for which collections this security scheme is added to the components.
// You have to apply it in configs/openapi.php too.
#[Collection(name: ['private', 'public'])]
class AnotherBearerTokenSecurityScheme extends SecuritySchemeFactory
{
    public function build(): SecurityScheme
    {
        return SecurityScheme::create('SomethingElse')
            ->type(SecurityScheme::TYPE_HTTP)
            ->scheme('bearer');
    }
}
