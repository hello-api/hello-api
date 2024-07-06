<?php

namespace App\Containers\AppSection\Authentication\UI\API\Documentation\RequestBodies;

use App\Containers\AppSection\Authentication\UI\API\Documentation\Schemas\SendVerificationEmailSchema;
use App\Ship\Documentation\API\GeneralMediaTypes;
use GoldSpecDigital\ObjectOrientedOAS\Objects\RequestBody;
use MohammadAlavi\LaravelOpenApi\Factories\RequestBodyFactory;

class SendVerificationEmailRequestBody extends RequestBodyFactory
{
    public function build(): RequestBody
    {
        return RequestBody::create()->content(...GeneralMediaTypes::for(SendVerificationEmailSchema::ref()));
    }
}
