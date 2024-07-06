<?php

namespace App\Containers\AppSection\Authentication\UI\API\Documentation\Parameters;

use App\Containers\AppSection\User\UI\API\Documentation\Schemas\UserTransformerIncludesSchema;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Parameter;
use MohammadAlavi\LaravelOpenApi\Factories\ParametersFactory;

class GetAuthenticatedUserParams extends ParametersFactory
{
    /**
     * @return Parameter[]
     */
    public function build(): array
    {
        return [Parameter::query()->name('include')->schema(UserTransformerIncludesSchema::ref())];
    }
}
