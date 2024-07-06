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
class LoginProxyForWebClientSchema extends SchemaFactory implements Reusable
{
    /**
     * @throws InvalidArgumentException
     */
    public function build(): SchemaContract
    {
        return Schema::object(class_basename($this))
            ->properties(
                EmailPropertySchema::ref('email'),
                Schema::string('password')
                    ->format(Schema::FORMAT_PASSWORD)
                    ->example('admin'),
                Schema::string('recaptcha_token')
                    ->default(env('GOOGLE_CAPTCHA_BYPASS_KEY'))
            )->required('email', 'password', 'recaptcha_token');
    }
}
