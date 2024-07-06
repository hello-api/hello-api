<?php

namespace App\Containers\AppSection\User\UI\API\Documentation\Schemas;

use App\Containers\AppSection\User\UI\API\Requests\UpdateUserPasswordRequest;
use App\Ship\Documentation\API\RuleExtractor;
use App\Ship\Documentation\Collections\PrivateCollection;
use GoldSpecDigital\ObjectOrientedOAS\Contracts\SchemaContract;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Schema;
use MohammadAlavi\LaravelOpenApi\Attributes\Collection;
use MohammadAlavi\LaravelOpenApi\Contracts\Reusable;
use MohammadAlavi\LaravelOpenApi\Factories\SchemaFactory;

#[Collection([PrivateCollection::class])]
// TODO: update rule documentation
class UpdateUserPasswordSchema extends SchemaFactory implements Reusable
{
    public function build(): SchemaContract
    {
        return Schema::object(class_basename($this))
            ->properties(
                Schema::string('current_password'),
                //                    ->description(RuleExtractor::getRuleFrom(UpdateUserPasswordRequest::class, 'current_password')),
                Schema::string('new_password')
                //                    ->description(RuleExtractor::getRuleFrom(UpdateUserPasswordRequest::class, 'new_password')),
            )->required('new_password');
    }
}
