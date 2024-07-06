<?php

namespace App\Containers\AppSection\Authentication\UI\API\Documentation\Schemas;

use App\Ship\Documentation\Collections\PrivateCollection;
use GoldSpecDigital\ObjectOrientedOAS\Contracts\SchemaContract;
use GoldSpecDigital\ObjectOrientedOAS\Exceptions\InvalidArgumentException;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Schema;
use MohammadAlavi\LaravelOpenApi\Attributes\Collection;
use MohammadAlavi\LaravelOpenApi\Contracts\Reusable;
use MohammadAlavi\LaravelOpenApi\Factories\SchemaFactory;

#[Collection([PrivateCollection::class])]
class OAuth2ClientCredentialsGrantSchema extends SchemaFactory implements Reusable
{
    /**
     * @throws InvalidArgumentException
     */
    public function build(): SchemaContract
    {
        return Schema::object(class_basename($this))
            ->properties(
                Schema::string('grant_type')->enum('client_credentials'),
                Schema::integer('client_id'),
                Schema::string('client_secret'),
                Schema::string('scope')->default(''),
            )->required('grant_type', 'client_id', 'client_secret');
    }
}
