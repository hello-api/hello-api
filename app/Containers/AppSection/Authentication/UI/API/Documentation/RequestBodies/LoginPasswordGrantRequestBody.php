<?php

namespace App\Containers\AppSection\Authentication\UI\API\Documentation\RequestBodies;

use App\Containers\AppSection\Authentication\UI\API\Documentation\Schemas\OAuth2PasswordGrantSchema;
use App\Ship\Documentation\API\GeneralMediaTypes;
use GoldSpecDigital\ObjectOrientedOAS\Objects\RequestBody;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Schema;
use MohammadAlavi\LaravelOpenApi\Factories\RequestBodyFactory;

class LoginPasswordGrantRequestBody extends RequestBodyFactory
{
    public function build(): RequestBody
    {
        return RequestBody::create()->content(
            // ...GeneralMediaTypes::for(OAuth2PasswordGrantSchema::ref())

            // If we provide only one of these ways to interactive with API,
            // we can remove the Schema and directly write it here.
            // Even though I personally don't use the json() way, I thought someone might find it useful.
            // MediaType::formUrlEncoded()->schema(OAuth2PasswordGrantSchema::ref()),
            // MediaType::json()->schema(OAuth2PasswordGrantSchema::ref()),

            // We can do the same with `GeneralMediaTypes` too, and get rid of creating that schema class.
            ...GeneralMediaTypes::for(
                Schema::object(class_basename($this))
                ->properties(
                    Schema::string('grant_type')->enum('password'),
                    Schema::string('username')
                        ->description('user email')
                        ->example('admin@praisecharts.com'),
                    Schema::string('password')
                        ->format(Schema::FORMAT_PASSWORD)
                        ->example('admin'),
                    Schema::integer('client_id'),
                    Schema::string('client_secret'),
                    Schema::string('scope')->default(''),
                )->required('grant_type', 'username', 'password', 'client_id', 'client_secret')
            )

            // Can't do this because Swagger UI doesn't support OneOf in RequestBody.
            // This is why we have to create a new endpoint for refresh token.
            // MediaType::formUrlEncoded()->schema(
            //     OneOf::create()->schemas(
            //         OAuth2PasswordGrantSchema::ref(),
            //         OAuth2RefreshTokenSchema::ref(),
            //     ),
            // ),
            // MediaType::json()->schema(
            //     OneOf::create()->schemas(
            //         OAuth2PasswordGrantSchema::ref(),
            //         OAuth2RefreshTokenSchema::ref(),
            //     ),
            // ),
        );
    }
}
