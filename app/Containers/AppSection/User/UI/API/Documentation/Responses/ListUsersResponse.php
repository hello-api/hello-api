<?php

namespace App\Containers\AppSection\User\UI\API\Documentation\Responses;

use GoldSpecDigital\ObjectOrientedOAS\Objects\MediaType;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Response;
use MohammadAlavi\LaravelOpenApi\Factories\ResponseFactory;

class ListUsersResponse extends ResponseFactory
{
    public function build(): Response
    {
        return Response::ok()->content(MediaType::json());
    }
}
