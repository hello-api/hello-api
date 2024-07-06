<?php

namespace App\Containers\AppSection\Authentication\UI\API\Documentation\SecuritySchemes;

use App\Ship\Documentation\Collections\PrivateCollection;
use GoldSpecDigital\ObjectOrientedOAS\Objects\SecurityScheme;
use MohammadAlavi\LaravelOpenApi\Attributes\Collection;
use MohammadAlavi\LaravelOpenApi\Factories\SecuritySchemeFactory;

#[Collection([PrivateCollection::class])]
class BearerTokenSecurityScheme extends SecuritySchemeFactory
{
    public function build(): SecurityScheme
    {
        return SecurityScheme::create('BearerToken')
            ->type(SecurityScheme::TYPE_HTTP)
            ->scheme('bearer');
    }
}
