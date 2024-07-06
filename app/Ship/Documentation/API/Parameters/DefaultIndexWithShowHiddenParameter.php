<?php

namespace App\Ship\Documentation\API\Parameters;

use GoldSpecDigital\ObjectOrientedOAS\Objects\Parameter;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Schema;
use MohammadAlavi\LaravelOpenApi\Factories\ParametersFactory;

class DefaultIndexWithShowHiddenParameter extends ParametersFactory
{
    /**
     * @return Parameter[]
     */
    public function build($additionalParams = []): array
    {
        $params = [
            Parameter::query()
                ->name('page')
                ->description('Page number')
                ->required(false)
                ->example(1)
                ->schema(Schema::integer()),
            Parameter::query()
                ->name('per_page')
                ->description('Per Page number')
                ->required(false)
                ->example(10)
                ->schema(Schema::integer()),
            Parameter::query()
                ->name('search')
                ->description('Search Term')
                ->required(false)
                ->example('search')
                ->schema(Schema::string()),
            Parameter::query()
                ->name('order_by')
                ->description('Order by')
                ->required(false)
                ->example('created_at')
                ->schema(Schema::string()),
            Parameter::query()
                ->name('order_direction')
                ->description('Order Direction')
                ->required(false)
                ->example('asc')
                ->schema((new Schema())->enum('asc', 'desc')),
            Parameter::query()
                ->name('show_hidden')
                ->description('show hidden')
                ->required(false)
                ->example('1')
                ->schema((new Schema())->enum('1', '0')),
        ];

        return $params;
    }
}
