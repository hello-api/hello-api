<?php

namespace App\Ship\Documentation\API\Parameters;

use GoldSpecDigital\ObjectOrientedOAS\Objects\Parameter;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Schema;
use MohammadAlavi\LaravelOpenApi\Factories\ParametersFactory;

class DefaultIndexParameter extends ParametersFactory
{
    /**
     * @return Parameter[]
     */
    public function build(): array
    {
        $params = [
            Parameter::query()
                ->name('page')
                ->description('Page number')
                ->required(false)
                ->example(1)
                ->schema(Schema::integer()),
            Parameter::query()
                ->name('limit')
                ->description('Per Page number')
                ->required(false)
                ->example(10)
                ->schema(Schema::integer()),
            Parameter::query()
                ->name('search')
                ->description('Search Term')
                ->required(false)
                ->schema(Schema::string()),
            Parameter::query()
                ->name('order_by')
                ->description('Order by')
                ->required(false)
                ->schema(Schema::string()),
            Parameter::query()
                ->name('order_direction')
                ->description('Order Direction')
                ->required(false)
                ->example('asc')
                ->schema((new Schema())->enum('asc', 'desc')),
            Parameter::query()
                ->name('filter')
                ->description('Filter')
                ->required(false)
                ->schema(Schema::string()),
        ];

        return $params;
    }
}
