<?php

namespace App\Containers\AppSection\Authorization\Tests\Unit\UI\API\Transformers;

use App\Containers\AppSection\Authorization\Models\Permission;
use App\Containers\AppSection\Authorization\Tests\UnitTestCase;
use App\Containers\AppSection\Authorization\UI\API\Transformers\PermissionTransformer;
use PHPUnit\Framework\Attributes\CoversClass;

#[CoversClass(PermissionTransformer::class)]
final class PermissionTransformerTest extends UnitTestCase
{
    private PermissionTransformer $transformer;

    public function testCanTransformSingleObject(): void
    {
        $permission = Permission::factory()->createOne();
        $expected = [
            'object' => $permission->getResourceKey(),
            'id' => $permission->getHashedKey(),
            'name' => $permission->name,
            'display_name' => $permission->display_name,
            'description' => $permission->description,
        ];

        $transformedResource = $this->transformer->transform($permission);

        $this->assertEquals($expected, $transformedResource);
    }

    public function testAvailableIncludes(): void
    {
        $this->assertSame([
            'roles',
        ], $this->transformer->getAvailableIncludes());
    }

    public function testDefaultIncludes(): void
    {
        $this->assertSame([], $this->transformer->getDefaultIncludes());
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->transformer = new PermissionTransformer();
    }
}
