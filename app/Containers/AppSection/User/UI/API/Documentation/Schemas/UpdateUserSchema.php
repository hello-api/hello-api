<?php

namespace App\Containers\AppSection\User\UI\API\Documentation\Schemas;

use App\Containers\AppSection\User\UI\API\Requests\UpdateUserRequest;
use App\Ship\Documentation\API\RuleExtractor;
use App\Ship\Documentation\Collections\PrivateCollection;
use GoldSpecDigital\ObjectOrientedOAS\Contracts\SchemaContract;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Schema;
use MohammadAlavi\LaravelOpenApi\Attributes\Collection;
use MohammadAlavi\LaravelOpenApi\Contracts\Reusable;
use MohammadAlavi\LaravelOpenApi\Factories\SchemaFactory;

#[Collection([PrivateCollection::class])]
class UpdateUserSchema extends SchemaFactory implements Reusable
{
    public function build(): SchemaContract
    {
        return Schema::object(class_basename($this))
            ->properties(
                Schema::string('name')
                    ->description(RuleExtractor::getRuleFrom(UpdateUserRequest::class, 'name')),
            );
    }
}
