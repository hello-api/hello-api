<?php

use App\Containers\AppSection\Authentication\UI\API\Documentation\SecuritySchemes\BearerTokenSecurityScheme;
use App\Containers\AppSection\Authentication\UI\API\Documentation\SecuritySchemes\OAuth2PasswordClientCredentialsSecurityScheme;
use App\Containers\AppSection\Authentication\UI\API\Documentation\Tags\AuthenticationTag;
use App\Containers\AppSection\User\UI\API\Documentation\Tags\UserTag;
use App\Ship\Documentation\Servers\MainServer;

$headerPath = app_path('Containers/AppSection/Documentation/UI/WEB/Views/swagger/header.md');
$headerContent = '';
if (file_exists($headerPath)) {
    $headerContent = file_get_contents($headerPath);
}

return [
    'collections' => [
        'private' => [
            'info' => [
                'title' => config('app.name'),
                'description' => "<details><summary>General Info</summary>  \n" . $headerContent . '</details>',
                'version' => '1.0.0',
            ],

            'servers' => [
                MainServer::class,
            ],

            'tags' => [
                AuthenticationTag::class,
                UserTag::class,
            ],

            // Registering all possible (available) security schemes here.
            'security' => [
                BearerTokenSecurityScheme::class,
                OAuth2PasswordClientCredentialsSecurityScheme::class,
            ],

            // Non standard attributes used by code/doc generation tools can be added here
            'extensions' => [
                // 'x-tagGroups' => [
                //     [
                //         'name' => 'General',
                //         'tags' => [
                //             'user',
                //         ],
                //     ],
                // ],
            ],

            // Route for exposing specification.
            // Leave uri null to disable.
            'route' => [
                'uri' => null,
                'middleware' => [],
            ],

            // Register custom middlewares for different objects.
            'middlewares' => [
                'paths' => [
                ],
                'components' => [
                ],
            ],
        ],

        'public' => [
            'info' => [
                'title' => config('app.name'),
                'description' => "<details><summary>General Info</summary>  \n" . $headerContent . '</details>',
                'version' => '1.0.0',
            ],

            'servers' => [
                MainServer::class,
            ],

            'tags' => [],

            // Registering all possible (available) security schemes here.
            'security' => [
                BearerTokenSecurityScheme::class,
                OAuth2PasswordClientCredentialsSecurityScheme::class,
            ],

            // Non standard attributes used by code/doc generation tools can be added here
            'extensions' => [
                // 'x-tagGroups' => [
                //     [
                //         'name' => 'General',
                //         'tags' => [
                //             'user',
                //         ],
                //     ],
                // ],
            ],

            // Route for exposing specification.
            // Leave uri null to disable.
            'route' => [
                'uri' => null,
                'middleware' => [],
            ],

            // Register custom middlewares for different objects.
            'middlewares' => [
                'paths' => [
                ],
                'components' => [
                ],
            ],
        ],
    ],

    // Directories to use for locating OpenAPI object definitions.
    'locations' => [
        'callbacks' => [
            app_path('Containers/*/*/UI/API/Documentation/Callbacks'),
        ],

        'request_bodies' => [
            app_path('Containers/*/*/UI/API/Documentation/RequestBodies'),
        ],

        'responses' => [
            app_path('Containers/*/*/UI/API/Documentation/Responses'),
        ],

        'schemas' => [
            app_path('Containers/*/*/UI/API/Documentation/Schemas'),
        ],

        'security_schemes' => [
            app_path('Containers/*/*/UI/API/Documentation/SecuritySchemes'),
        ],
    ],
];
