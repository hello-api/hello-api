<?php

namespace App\Containers\AppSection\Authentication\UI\API\Documentation\RequestBodies;

use App\Containers\AppSection\Authentication\UI\API\Requests\LoginWithLegacyTokenRequest;
use App\Ship\Documentation\API\GeneralMediaTypes;
use App\Ship\Documentation\API\SchemaExtractor;
use GoldSpecDigital\ObjectOrientedOAS\Objects\RequestBody;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Schema;
use MohammadAlavi\LaravelOpenApi\Factories\RequestBodyFactory;

class LoginWithLegacyTokenRequestBody extends RequestBodyFactory
{
    public function build(): RequestBody
    {
        return RequestBody::create()->content(
            ...GeneralMediaTypes::for(
                Schema::object(class_basename($this))
                ->properties(
                    ...SchemaExtractor::extractFromRequest(LoginWithLegacyTokenRequest::class)
                )
            )
        );
    }
}
