<?php

namespace App\Ship\Documentation\API\Parameters;

use GoldSpecDigital\ObjectOrientedOAS\Objects\Parameter;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Schema;
use MohammadAlavi\LaravelOpenApi\Factories\ParametersFactory;

class DefaultIdParam extends ParametersFactory
{
    /**
     * @return Parameter[]
     */
    public function build(): array
    {
        return [
            Parameter::path()
                ->name('id')
                ->description('default id')
                ->required(true)
                ->schema(Schema::integer('id')),
        ];
    }
}
