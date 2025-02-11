<?php

namespace App\Ship\Tests\Unit\Configs;

use App\Ship\Tests\ShipTestCase;
use League\Fractal\Serializer\DataArraySerializer;
use PHPUnit\Framework\Attributes\CoversNothing;

#[CoversNothing]
final class RepositoryTest extends ShipTestCase
{
    public function testConfigHasCorrectValues(): void
    {
        $config = config('repository');
        $expected = [
            'pagination' => [
                'limit' => env('PAGINATION_LIMIT_DEFAULT', 10),
                'skip' => env('PAGINATION_SKIP', false),
            ],
            'fractal' => [
                'params' => [
                    'include' => 'include',
                ],
                'serializer' => DataArraySerializer::class,
            ],
            'cache' => [
                'enabled' => env('ELOQUENT_QUERY_CACHE', false),
                'minutes' => env('ELOQUENT_QUERY_CACHE_TIME', 30),
                'repository' => 'cache',
                'clean' => [
                    'enabled' => true,
                    'on' => [
                        'create' => true,
                        'update' => true,
                        'delete' => true,
                    ],
                ],
                'params' => [
                    'skipCache' => 'skipCache',
                ],
                'allowed' => [
                    'only' => null,
                    'except' => null,
                ],
            ],
            'criteria' => [
                'acceptedConditions' => [
                    '=',
                    'like',
                    'in',
                ],
                'params' => [
                    'search' => 'search',
                    'searchFields' => 'searchFields',
                    'filter' => 'l5_filter',
                    'orderBy' => 'orderBy',
                    'sortedBy' => 'sortedBy',
                    'with' => 'l5_with',
                    'searchJoin' => 'searchJoin',
                    'withCount' => 'withCount',
                ],
            ],
            'generator' => [
                'basePath' => env('SRC_PATH', app()->path()),
                'rootNamespace' => env('ROOT_NAMESPACE', 'App\\'),
                'stubsOverridePath' => app()->path(),
                'paths' => [
                    'models' => 'Entities',
                    'repositories' => 'Repositories',
                    'interfaces' => 'Repositories',
                    'transformers' => 'Transformers',
                    'presenters' => 'Presenters',
                    'validators' => 'Validators',
                    'controllers' => 'Http/Controllers',
                    'provider' => 'RepositoryServiceProvider',
                    'criteria' => 'Criteria',
                ],
            ],
        ];

        $this->assertEqualsCanonicalizing($expected, $config);
    }
}
