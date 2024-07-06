<?php

namespace App\Containers\AppSection\Authentication\UI\API\Documentation\Responses;

use GoldSpecDigital\ObjectOrientedOAS\Objects\MediaType;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Response;
use MohammadAlavi\LaravelOpenApi\Factories\ResponseFactory;

class GetAuthenticatedUserResponse extends ResponseFactory
{
    public function build(): Response
    {
        return Response::ok()->content(MediaType::json());
    }
}
