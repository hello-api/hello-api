<?php

namespace App\Ship\Documentation\API;

use GoldSpecDigital\ObjectOrientedOAS\Objects\Schema;

class SchemaExtractor
{
    public static function extractFromRequest(string $requestClass, array $example = []): array
    {
        $schemas = [];
        $request = new $requestClass();
        $rules = $request->rules();

        foreach ($rules as $field => $rule) {
            $type = self::getSchemaType($rule);
            $description = RuleExtractor::getRuleFrom($requestClass, $field);

            // Check if example exists for this field
            if (array_key_exists($field, $example)) {
                $schema = Schema::$type($field)
                    ->description($description)
                    ->example($example[$field]);
            } else {
                $schema = Schema::$type($field)
                    ->description($description);
            }

            $schemas[] = $schema;
        }

        return $schemas;
    }

    private static function getSchemaType($rule): string
    {
        if (false !== strpos($rule, 'string')) {
            return 'string';
        }

        if (false !== strpos($rule, 'integer')) {
            return 'integer';
        }

        if (false !== strpos($rule, 'boolean')) {
            return 'boolean';
        }

        // Handle other types here

        return 'string'; // Default type
    }
}
