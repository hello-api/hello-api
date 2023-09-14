<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Locale
    |--------------------------------------------------------------------------
    |
    | Language header docs
    |
    */

    'locale' => '.' . env('APIDOC_LOCALE', 'en'),

    /*
    |--------------------------------------------------------------------------
    | Executable
    |--------------------------------------------------------------------------
    |
    | Specify how you run or access the `apidoc` tool on your machine.
    |
    */

    'executable' => 'node_modules/.bin/apidoc',

    /*
    |--------------------------------------------------------------------------
    | API Types
    |--------------------------------------------------------------------------
    |
    | The `types` helps to generate multiple documentations, by grouping them
    | under types names. You can add or remove any type. By default,
    | `public` and `private` types are set.
    |
    | url: The url to access that generated API documentation.
    |
    | routes: The route file to read when generating this documentation.
    |         Every route file will have the following name format:
    |         `{endpoint-name}.v{version-number}.{documentation-type}.php`.
    |
    */

    'types' => [
        'public' => [
            'url' => env('PUBLIC_DOCS_URL', 'docs'),
            'folder-name' => 'documentation/public', // doc folder name
            'routes' => [
                'public',
            ],
        ],

        'private' => [
            'url' => env('PRIVATE_DOCS_URL', 'docs/private'),
            'folder-name' => 'documentation/private', // doc folder name
            'routes' => [
                'private',
            ],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | HTML Files
    |--------------------------------------------------------------------------
    |
    | Specify where to put the generated HTML files.
    |
    */

    'html_files' => env('SRC_PATH', app()->path()) . '/Containers/Vendor/Documentation/UI/WEB/Views/',

    /*
    |--------------------------------------------------------------------------
    | Documentation Container, Section Name
    |--------------------------------------------------------------------------
    |
    | Specify the Section name where the Documentation Container is located.
    |
    */
    'section_name' => 'Vendor',

    /*
    |--------------------------------------------------------------------------
    | Protect Private Docs by auth:web Middleware
    |--------------------------------------------------------------------------
    |
    | If enabled, users need to log in and have proper roles/permissions to access private docs
    |
    */

    'protect-private-docs' => env('PROTECT_PRIVATE_DOCS', app()->isProduction()),

    /*
    |--------------------------------------------------------------------------
    | Permission to Access Protected Private Docs
    |--------------------------------------------------------------------------
    |
    | Permission needed to access protected private docs route
    |
    | You have to create and give it to any user (role) you want to have access to the protected private docs.
    |
    */

    'access-private-docs-permission' => env('ACCESS_PRIVATE_DOCS_PERMISSION', 'access-private-docs'),

    /*
    |--------------------------------------------------------------------------
    | Roles That Have Access to Protected Private Docs
    |--------------------------------------------------------------------------
    |
    | Add any roles that have access to the protected private docs. e.g. ['admin']
    |
    */

    'access-private-docs-roles' => [],

    /*
    |--------------------------------------------------------------------------
    | Enable Sending Sample Request
    |--------------------------------------------------------------------------
    |
    | Enable sending of sample request
    |
    */

    'enable-sending-sample-request' => true,
];
