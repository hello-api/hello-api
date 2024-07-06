<?php

namespace App\Ship\Documentation\API;

use GoldSpecDigital\ObjectOrientedOAS\Contracts\SchemaContract;
use GoldSpecDigital\ObjectOrientedOAS\Objects\MediaType;

class GeneralMediaTypes
{
    public static function create(): array
    {
        return [
            MediaType::formUrlEncoded(),
            MediaType::json(),
        ];
    }

    public static function for(SchemaContract $schema): array
    {
        return [
            MediaType::formUrlEncoded()->schema($schema),
            MediaType::json()->schema($schema),
        ];
    }
}
