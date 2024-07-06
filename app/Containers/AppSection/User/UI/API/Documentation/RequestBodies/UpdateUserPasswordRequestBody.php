<?php

namespace App\Containers\AppSection\User\UI\API\Documentation\RequestBodies;

use App\Containers\AppSection\User\UI\API\Documentation\Schemas\UpdateUserPasswordSchema;
use App\Ship\Documentation\API\GeneralMediaTypes;
use GoldSpecDigital\ObjectOrientedOAS\Objects\RequestBody;
use MohammadAlavi\LaravelOpenApi\Factories\RequestBodyFactory;

class UpdateUserPasswordRequestBody extends RequestBodyFactory
{
    public function build(): RequestBody
    {
        return RequestBody::create()->content(...GeneralMediaTypes::for(UpdateUserPasswordSchema::ref()));
    }
}
