<?php

namespace App\Containers\AppSection\Authentication\UI\API\Documentation\Schemas;

use App\Containers\AppSection\Authentication\UI\API\Documentation\Schemas\Properties\EmailPropertySchema;
use App\Ship\Documentation\Collections\PrivateCollection;
use GoldSpecDigital\ObjectOrientedOAS\Contracts\SchemaContract;
use GoldSpecDigital\ObjectOrientedOAS\Exceptions\InvalidArgumentException;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Schema;
use MohammadAlavi\LaravelOpenApi\Attributes\Collection;
use MohammadAlavi\LaravelOpenApi\Contracts\Reusable;
use MohammadAlavi\LaravelOpenApi\Factories\SchemaFactory;

#[Collection([PrivateCollection::class])]
class ForgotPasswordSchema extends SchemaFactory implements Reusable
{
    /**
     * @throws InvalidArgumentException
     */
    public function build(): SchemaContract
    {
        return Schema::object(class_basename($this))
            ->properties(
                EmailPropertySchema::ref('email'),
                Schema::string('reseturl')
                    ->enum(...config('appSection-authentication.allowed-reset-password-urls'))
                    ->example(config('appSection-authentication.allowed-reset-password-urls')[0])
            )->required('email', 'reseturl');
    }
}
