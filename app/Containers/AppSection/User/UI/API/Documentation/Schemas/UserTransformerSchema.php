<?php

namespace App\Containers\AppSection\User\UI\API\Documentation\Schemas;

use App\Ship\Documentation\Collections\PrivateCollection;
use GoldSpecDigital\ObjectOrientedOAS\Contracts\SchemaContract;
use GoldSpecDigital\ObjectOrientedOAS\Objects\AllOf;
use GoldSpecDigital\ObjectOrientedOAS\Objects\AnyOf;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Not;
use GoldSpecDigital\ObjectOrientedOAS\Objects\OneOf;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Schema;
use MohammadAlavi\LaravelOpenApi\Attributes\Collection;
use MohammadAlavi\LaravelOpenApi\Contracts\Reusable;
use MohammadAlavi\LaravelOpenApi\Factories\SchemaFactory;

#[Collection([PrivateCollection::class])]
class UserTransformerSchema extends SchemaFactory implements Reusable
{
    /**
     * @return AllOf|OneOf|AnyOf|Not|Schema
     */
    public function build(): SchemaContract
    {
        return Schema::object('UserTransformerSchema')
            ->properties(
                Schema::string('object')->example('User'),
                Schema::string('id')->example('5z3v5g'),
                Schema::string('name')->example('John Doe'),
                Schema::string('email')->example('john@doe.com'),
                Schema::string('email_verified_at')->example('2021-08-18T15:00:00.000000Z'),
            );
    }
}
