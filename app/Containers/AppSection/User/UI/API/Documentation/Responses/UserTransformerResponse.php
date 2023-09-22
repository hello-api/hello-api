<?php

namespace App\Containers\AppSection\User\UI\API\Documentation\Responses;

use App\Containers\AppSection\User\UI\API\Documentation\Schemas\UserTransformerSchema;
use GoldSpecDigital\ObjectOrientedOAS\Objects\MediaType;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Response;
use Vyuldashev\LaravelOpenApi\Factories\ResponseFactory;

class UserTransformerResponse extends ResponseFactory
{
    public function build(): Response
    {
        return Response::ok()
            ->content(MediaType::json()->schema((new UserTransformerSchema())->build()))
            ->description('Successful response');
    }
}
