<?php

namespace App\Containers\AppSection\Authentication\UI\API\Documentation\Parameters;

use App\Containers\AppSection\Authentication\UI\API\Documentation\Schemas\Properties\EmailPropertySchema;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Parameter;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Schema;
use MohammadAlavi\LaravelOpenApi\Factories\ParametersFactory;

class RegisterUserParams extends ParametersFactory
{
    /**
     * @return Parameter[]
     */
    public function build(): array
    {
        return [
            Parameter::query()->name('email')
                ->schema(EmailPropertySchema::ref())
                ->required(),
            Parameter::query()->name('password')
                ->schema(
                    Schema::string('password')
                    ->format(Schema::FORMAT_PASSWORD)
                )->required(),
            Parameter::query()->name('name')
                ->schema(
                    Schema::string('name')
                    ->minLength(2)
                    ->maxLength(50)
                ),
            Parameter::query()->name('verification_url')
                ->schema(
                    Schema::string('verification_url')
                    ->enum(...config('appSection-authentication.allowed-verify-email-urls'))
                ),
        ];
    }
}
