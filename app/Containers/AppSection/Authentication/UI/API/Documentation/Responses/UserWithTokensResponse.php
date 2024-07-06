<?php

namespace App\Containers\AppSection\Authentication\UI\API\Documentation\Responses;

use GoldSpecDigital\ObjectOrientedOAS\Objects\MediaType;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Response;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Schema;
use MohammadAlavi\LaravelOpenApi\Factories\ResponseFactory;

class UserWithTokensResponse extends ResponseFactory
{
    public function build(): Response
    {
        return Response::ok()->content(
            MediaType::json()->schema(
                Schema::object()
                    ->properties(
                        Schema::object('user')
                            ->properties(
                                Schema::string('object')->example('User')
                            ),
                        Schema::object('tokens')
                            ->properties(
                                Schema::string('token_type')->example('Bearer'),
                                Schema::integer('expires_in')->example(315360000),
                                Schema::string('access_token')->example('eyJ0eXAiOiJKV1QiLCJhbG...'),
                                Schema::string('refresh_token')->example('ZFDPA1S7H8Wydjkjl+xt+hPGWTagX...'),
                            )
                    )
            )
        );
    }
}
