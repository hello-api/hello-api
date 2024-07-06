<?php

namespace App\Containers\AppSection\Authentication\UI\API\Documentation\Schemas\Properties;

use App\Ship\Documentation\Collections\PrivateCollection;
use GoldSpecDigital\ObjectOrientedOAS\Contracts\SchemaContract;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Schema;
use MohammadAlavi\LaravelOpenApi\Attributes\Collection;
use MohammadAlavi\LaravelOpenApi\Contracts\Reusable;
use MohammadAlavi\LaravelOpenApi\Factories\SchemaFactory;

#[Collection([PrivateCollection::class])]
class EmailPropertySchema extends SchemaFactory implements Reusable
{
    public function build(): SchemaContract
    {
        return Schema::string(class_basename($this))
            // TODO: Get this from the request rules
            ->description('email')
            ->example('admin@praisecharts.com');
    }
}
