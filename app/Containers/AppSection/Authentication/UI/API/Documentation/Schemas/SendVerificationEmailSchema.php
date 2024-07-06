<?php

namespace App\Containers\AppSection\Authentication\UI\API\Documentation\Schemas;

use App\Containers\AppSection\Authentication\UI\API\Requests\SendVerificationEmailRequest;
use App\Ship\Documentation\API\RuleExtractor;
use App\Ship\Documentation\Collections\PrivateCollection;
use GoldSpecDigital\ObjectOrientedOAS\Contracts\SchemaContract;
use GoldSpecDigital\ObjectOrientedOAS\Exceptions\InvalidArgumentException;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Schema;
use MohammadAlavi\LaravelOpenApi\Attributes\Collection;
use MohammadAlavi\LaravelOpenApi\Contracts\Reusable;
use MohammadAlavi\LaravelOpenApi\Factories\SchemaFactory;

#[Collection([PrivateCollection::class])]
class SendVerificationEmailSchema extends SchemaFactory implements Reusable
{
    /**
     * @throws InvalidArgumentException
     */
    public function build(): SchemaContract
    {
        return Schema::object(class_basename($this))
            ->properties(
                Schema::string('verification_url')
                    ->description(RuleExtractor::getRuleFrom(SendVerificationEmailRequest::injectData(), 'verification_url'))
                    ->example('https://example.com/verify-email?token={token}&email={email}')
            )->required('verification_url');
    }
}
