<?php

namespace App\Ship\Documentation\API;

use App\Ship\Parents\Requests\Request;

class RuleExtractor
{
    private function __construct()
    {
    }

    /**
     * Extract the rules from the request.
     *
     * @param Request|string $request the request to extract the rules from (FQCN or instance)
     * @param string $rule the name of the rule to extract
     *
     * @return string the extracted rule separated by pipes. e.g. "required|url|in:https://example.com"
     */
    public static function getRuleFrom(Request|string $request, string $rule): string
    {
        if (is_string($request) && class_exists($request)) {
            $request = new $request();
        }

        assert($request instanceof Request);

        $rules = $request->rules()[$rule];
        if (is_string($rules)) {
            return $rules;
        }

        return implode('|', $rules);
    }
}
