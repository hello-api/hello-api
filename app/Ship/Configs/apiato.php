<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Enable / Disable Hashed ID
    |--------------------------------------------------------------------------
    */
    'hash-id' => env('HASH_ID', true),

    'api' => [
        /*
        |--------------------------------------------------------------------------
        | API URL
        |--------------------------------------------------------------------------
        */
        'url' => env('API_URL', 'http://localhost'),

        /*
        |--------------------------------------------------------------------------
        | Access Token Expiration Time
        |--------------------------------------------------------------------------
        |
        | In Minutes. Default to 1,440 minutes = 1 day
        |
        */
        'expires-in' => env('API_TOKEN_EXPIRES', 1440),

        /*
        |--------------------------------------------------------------------------
        | Refresh Token Expiration Time
        |--------------------------------------------------------------------------
        |
        | In Minutes. Default to 43,200 minutes = 30 days
        |
        */
        'refresh-expires-in' => env('API_REFRESH_TOKEN_EXPIRES', 43200),

        /*
        |--------------------------------------------------------------------------
        | Enable/Disable Implicit Grant
        |--------------------------------------------------------------------------
        */
        'enabled-implicit-grant' => env('API_ENABLE_IMPLICIT_GRANT', true),

        /*
        |--------------------------------------------------------------------------
        | Rate Limit (throttle)
        |--------------------------------------------------------------------------
        |
        | Attempts per minutes.
        | `attempts` is the number of attempts per `expires` in minutes.
        |
        */
        'rate-limiter' => [
            'name' => env('GLOBAL_API_RATE_LIMIT_NAME', 'api'),
            'enabled' => env('GLOBAL_API_RATE_LIMIT_ENABLED', true),
            'attempts' => env('GLOBAL_API_RATE_LIMIT_ATTEMPTS_PER_MIN', '30'),
            'expires' => env('GLOBAL_API_RATE_LIMIT_EXPIRES_IN_MIN', '1'),
        ],
    ],

    'requests' => [
        /*
        |--------------------------------------------------------------------------
        | Force Request Header to Contain header
        |--------------------------------------------------------------------------
        |
        | By default, users can send request without defining the accept header and
        | setting it to [ accept = application/json ].
        | To force the users to define that header, set this to true.
        | When set to true, a PHP exception will be thrown preventing users from access
        | When set to false, the header will contain a warning message.
        |
        */
        'force-accept-header' => false,

        /*
        |--------------------------------------------------------------------------
        | Use ETags
        |--------------------------------------------------------------------------
        |
        | This option appends an "ETag" HTTP Header to the Response. This ETag is a
        | calculated hash of the content to be delivered.
        | Clients can add an "If-None-Match" HTTP Header to the Request and submit
        | an (old) ETag. These ETags are validated. If they match (are the same),
        | an empty BODY with HTTP STATUS 304 (not modified) is returned!
        |
        */
        'use-etag' => false,

        'params' => [
            // TODO: BC: remove this after removing its usage in ResponseTrait in Core
            'filter' => 'filter',
        ],
    ],
];
