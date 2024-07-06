<?php

namespace App\Containers\AppSection\Authentication\UI\API\Documentation\Responses;

use GoldSpecDigital\ObjectOrientedOAS\Objects\MediaType;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Response;
use MohammadAlavi\LaravelOpenApi\Factories\ResponseFactory;

class SendVerificationEmailResponse extends ResponseFactory
{
    public function build(): Response
    {
        return Response::create()
            ->statusCode(204)
            ->description('Accepted')
            ->content(MediaType::json());
    }
}
