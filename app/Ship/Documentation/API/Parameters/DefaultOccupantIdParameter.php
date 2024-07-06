<?php

namespace App\Ship\Documentation\API\Parameters;

use GoldSpecDigital\ObjectOrientedOAS\Objects\Parameter;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Schema;
use MohammadAlavi\LaravelOpenApi\Factories\ParametersFactory;

class DefaultOccupantIdParameter extends ParametersFactory
{
    /**
     * @return Parameter[]
     */
    public function build(): array
    {
        $params = [
            Parameter::query()
                ->name('occupant_id')
                ->description('Occupant Id')
                ->required(false)
                ->example(1)
                ->schema(Schema::integer()),
        ];

        return $params;
    }
}
