<?php

namespace App\Containers\AppSection\Authentication\Classes;

use App\Containers\AppSection\Authentication\DataTransferObjects\IncomingLoginField;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class LoginFieldParser
{
    /**
     * Extract all matching login fields from the given data.
     * The login fields are the fields that are allowed to be used as login credentials.
     * The login fields are defined in the config file.
     * The login fields are extracted from the given data.
     * The login fields are returned as an array of IncomingLoginField objects.
     * The login fields are returned in the order they are defined in the config file.
     * TODO: update this docblock.
     *
     * @param array<string, mixed> $data
     *
     * @return IncomingLoginField[]
     */
    public static function extractAll(array $data): array
    {
        $result = static::extractAllMatchingLoginFields($data);

        if ([] === $result) {
            throw new \RuntimeException('No matching login field found');
        }

        return $result;
    }

    /**
     * @return IncomingLoginField[]
     */
    private static function extractAllMatchingLoginFields(array $data): array
    {
        $result = [];
        foreach (static::getAllowedLoginFields() as $fieldName) {
            $fieldValue = static::getMatchingLoginFieldValue($fieldName, $data);

            if (static::loginFieldHasValue($fieldValue)) {
                $result[] = new IncomingLoginField($fieldName, $fieldValue);
            }
        }

        return $result;
    }

    /**
     * @return array<int, string> [key => field]
     */
    private static function getAllowedLoginFields(): array
    {
        $allowedLoginFields = config('appSection-authentication.login.fields');
        if (!$allowedLoginFields) {
            $allowedLoginFields = ['email' => []];
        }

        if (!is_array($allowedLoginFields)) {
            throw new \InvalidArgumentException('Login {fields} property must be an array, ' . gettype($allowedLoginFields) . ' given');
        }

        $fieldNames = array_keys($allowedLoginFields);
        foreach ($fieldNames as $key => $fieldName) {
            if (!is_string($fieldName)) {
                throw new \InvalidArgumentException('Login fields keys must be a string, ' . gettype($fieldName) . ' given');
            }
        }

        return $fieldNames;
    }

    private static function getMatchingLoginFieldValue(string $field, array $from): string|null
    {
        $result = Arr::get($from, static::prepareLoginField($field));
        if (!is_string($result) || empty($result)) {
            return null;
        }

        return $result;
    }

    private static function prepareLoginField(string $field): string
    {
        return static::getPrefix() . $field;
    }

    private static function getPrefix(): string
    {
        return config('appSection-authentication.login.prefix', '');
    }

    private static function loginFieldHasValue(string|null $loginFieldValue): bool
    {
        return null !== $loginFieldValue;
    }

    // TODO: I think this should be moved to a separate class
    public static function mergeValidationRules(array $rules): array
    {
        /**
         * @var string $prefix
         * @var array $elements
         */
        $prefix = config('appSection-authentication.login.prefix', '');
        $elements = config('appSection-authentication.login.fields', ['email' => []]);

        if (!is_array($elements)) {
            throw new \InvalidArgumentException('The login fields must be an array');
        }

        if (1 === count($elements)) {
            $key = array_key_first($elements);
            $fieldRules = self::getUniqueRules($elements[$key]);

            if (!Str::contains($fieldRules, 'required')) {
                $fieldRules = 'required|' . $fieldRules;
            }

            $fieldName = "{$prefix}{$key}";
            $rules[$fieldName] = self::trimPipes($fieldRules);

            return $rules;
        }

        foreach ($elements as $key => $fieldRules) {
            // build all other login fields together
            $otherLoginFields = Arr::except($elements, $key);
            $otherLoginFields = array_keys($otherLoginFields);
            $otherLoginFields = preg_filter('/^/', $prefix, $otherLoginFields);
            $otherLoginFields = implode(',', $otherLoginFields);
            $fieldRules = self::getUniqueRules($fieldRules);
            if (Str::contains($fieldRules, 'required')) {
                $fieldRules = str_replace('required', '', $fieldRules);
            }
            $fieldName = "{$prefix}{$key}";
            $fieldRules = "required_without_all:{$otherLoginFields}|{$fieldRules}";
            $fieldRules = self::trimPipes($fieldRules);

            $rules[$fieldName] = $fieldRules;
        }

        return $rules;
    }

    private static function trimPipes(string $rule): string
    {
        $rule = str_replace('||', '|', $rule);

        return trim($rule, '|');
    }

    private static function getUniqueRules(mixed $attributeRules): string
    {
        return implode('|', array_unique(explode('|', implode('|', $attributeRules))));
    }
}
