<?php

namespace App\Containers\AppSection\Authentication\UI\API\Documentation\Tags;

use GoldSpecDigital\ObjectOrientedOAS\Objects\Tag;
use MohammadAlavi\LaravelOpenApi\Factories\TagFactory;

class AuthenticationTag extends TagFactory
{
    public function build(): Tag
    {
        return Tag::create()
            ->name('Authentication')
            ->description('Authentication operations');
    }
}
