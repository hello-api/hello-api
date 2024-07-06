<?php

namespace App\Containers\AppSection\Authentication\UI\API\Documentation\Parameters;

use GoldSpecDigital\ObjectOrientedOAS\Objects\Parameter;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Schema;
use MohammadAlavi\LaravelOpenApi\Factories\ParametersFactory;

class LoginAsUserParams extends ParametersFactory
{
    /**
     * @return Parameter[]
     */
    public function build(): array
    {
        return [
            Parameter::path()
                ->name('id')
                ->required()
                ->schema(Schema::string()),
        ];
    }
}
