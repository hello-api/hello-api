<?php

namespace App\Containers\AppSection\Authentication\UI\API\Documentation\Responses;

use GoldSpecDigital\ObjectOrientedOAS\Objects\MediaType;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Response;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Schema;
use MohammadAlavi\LaravelOpenApi\Factories\ResponseFactory;

class LogoutResponse extends ResponseFactory
{
    public function build(): Response
    {
        return Response::create()
            ->statusCode(204)
            ->description('No Content')
            ->content(MediaType::json()->schema(Schema::object('message')->properties(
                Schema::string('message')->example('Token revoked successfully.'),
            )));
    }
}
