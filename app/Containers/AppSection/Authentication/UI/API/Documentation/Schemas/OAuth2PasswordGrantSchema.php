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
class OAuth2PasswordGrantSchema extends SchemaFactory implements Reusable
{
    /**
     * @throws InvalidArgumentException
     */
    public function build(): SchemaContract
    {
        return Schema::object(class_basename($this))
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
            )->required('grant_type', 'username', 'password', 'client_id', 'client_secret');
    }
}
