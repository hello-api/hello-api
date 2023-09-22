<?php

namespace App\Containers\AppSection\User\UI\API\Documentation\Parameters;

use GoldSpecDigital\ObjectOrientedOAS\Objects\Parameter;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Schema;
use Vyuldashev\LaravelOpenApi\Factories\ParametersFactory;

class UpdateUser extends ParametersFactory
{
    /**
     * @return Parameter[]
     */
    public function build(): array
    {
        return [
            Parameter::path()
                ->name('id')
                ->description('Parameter description')
                ->required(true)
                ->schema(Schema::string()),
            Parameter::query()
                ->name('name')
                ->description('Parameter description')
                ->required(false)
                ->schema(Schema::string()),
        ];
    }
}
