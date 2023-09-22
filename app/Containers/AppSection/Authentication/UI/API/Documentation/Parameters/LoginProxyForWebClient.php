<?php

namespace App\Containers\AppSection\Authentication\UI\API\Documentation\Parameters;

use GoldSpecDigital\ObjectOrientedOAS\Objects\Parameter;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Schema;
use Vyuldashev\LaravelOpenApi\Factories\ParametersFactory;

class LoginProxyForWebClient extends ParametersFactory
{
    /**
     * @return Parameter[]
     */
    public function build(): array
    {
        return [
            Parameter::query()
                ->name('email'),
            Parameter::query()
                ->name('password')
                ->description('Parameter description')
                ->required(false)
                ->schema(Schema::string()),
        ];
    }
}
