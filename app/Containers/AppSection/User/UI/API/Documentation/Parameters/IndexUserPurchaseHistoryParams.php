<?php

namespace App\Containers\AppSection\User\UI\API\Documentation\Parameters;

use GoldSpecDigital\ObjectOrientedOAS\Objects\Parameter;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Schema;
use MohammadAlavi\LaravelOpenApi\Factories\ParametersFactory;

class IndexUserPurchaseHistoryParams extends ParametersFactory
{
    public function build(): array
    {
        return [
            Parameter::query()
                ->name('type')
                ->description('Type of purchase history')
                ->required()
                ->schema(Schema::string()->enum('purchases', 'invoices', 'memberships')),
            Parameter::query()
                ->name('last_days')
                ->description('')
                ->schema(Schema::string()),
            Parameter::query()
                ->name('per_page')
                ->description('')
                ->schema(Schema::string()),
        ];
    }
}
