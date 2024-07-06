<?php

namespace App\Containers\AppSection\User\UI\API\Documentation\Parameters;

use GoldSpecDigital\ObjectOrientedOAS\Objects\Parameter;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Schema;
use MohammadAlavi\LaravelOpenApi\Factories\ParametersFactory;

class FindUserByIdParams extends ParametersFactory
{
    public function build(): array
    {
        return [
            Parameter::path()
                ->name('id')
                ->description('User ID')
                ->required()
                ->schema(Schema::string()),
            Parameter::query()
                ->name('include')
                ->description('')
                ->required(false)
                ->schema(Schema::string()),
        ];
    }
}
