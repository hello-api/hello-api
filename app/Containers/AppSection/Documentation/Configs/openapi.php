<?php

use App\Containers\AppSection\User\UI\API\Documentation\SecuritySchemes\BearerTokenSecurityScheme;

return [

    'collections' => [

        'private' => [

            'info' => [
                'title' => config('app.name'),
                'description' =>
                    "<details><summary>General Info</summary>  \n".
                    // TODO: we have to check if the file exists first!
                    // this will throw "Failed to open stream: No such file or directory" if file does not exist.
                    file_get_contents(app_path('Containers/AppSection/Documentation/UI/WEB/Views/swagger/header.md')).
                    "</details>",
                'version' => '1.0.0',
                'contact' => [
                    'name' => 'Mohammad Alavi',
                    'email' => 'gandalf.the@gray',
                    'url' => 'https://www.google.com',
                ],
                'license' => [
                    'name' => 'MIT',
                    'url' => 'https://opensource.org/licenses/MIT',
                ],
            ],

            'servers' => [
                [
                    'url' => env('API_URL'),
                    'description' => null,
                    'variables' => [],
                ],
            ],

            'tags' => [

                // [
                //    'name' => 'user',
                //    'description' => 'Application users',
                // ],

            ],

            'security' => [
                // GoldSpecDigital\ObjectOrientedOAS\Objects\SecurityRequirement::create()->securityScheme('JWT'),
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
                    //
                ],
                'components' => [
                    //
                ],
            ],

        ],

        'public' => [

            'info' => [
                'title' => config('app.name'),
                'description' => 'a desc!',
                'version' => '2.0.0',
                'contact' => ['name' => 'test'],
            ],

            'servers' => [
                [
                    'url' => env('API_URL'),
                    'description' => null,
                    'variables' => [],
                ],
            ],

            'tags' => [

                // [
                //    'name' => 'user',
                //    'description' => 'Application users',
                // ],

            ],

            'security' => [
                // GoldSpecDigital\ObjectOrientedOAS\Objects\SecurityRequirement::create()->securityScheme('JWT'),
                GoldSpecDigital\ObjectOrientedOAS\Objects\SecurityRequirement::create()->securityScheme(BearerTokenSecurityScheme::class),
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
                    //
                ],
                'components' => [
                    //
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
