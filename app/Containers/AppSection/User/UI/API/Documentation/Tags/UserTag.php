<?php

namespace App\Containers\AppSection\User\UI\API\Documentation\Tags;

use GoldSpecDigital\ObjectOrientedOAS\Objects\Tag;
use MohammadAlavi\LaravelOpenApi\Factories\TagFactory;

class UserTag extends TagFactory
{
    public function build(): Tag
    {
        return Tag::create()
            ->name('User')
            ->description('User operations');
    }
}
