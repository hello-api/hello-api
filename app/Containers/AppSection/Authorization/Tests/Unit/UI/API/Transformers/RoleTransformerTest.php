<?php

namespace App\Containers\AppSection\Authorization\Tests\Unit\UI\API\Transformers;

use App\Containers\AppSection\Authorization\Models\Role;
use App\Containers\AppSection\Authorization\Tests\UnitTestCase;
use App\Containers\AppSection\Authorization\UI\API\Transformers\RoleTransformer;
use PHPUnit\Framework\Attributes\CoversClass;

#[CoversClass(RoleTransformer::class)]
final class RoleTransformerTest extends UnitTestCase
{
    private RoleTransformer $transformer;

    public function testCanTransformSingleObject(): void
    {
        $role = Role::factory()->createOne();
        $expected = [
            'object' => $role->getResourceKey(),
            'id' => $role->getHashedKey(),
            'name' => $role->name,
            'display_name' => $role->display_name,
            'description' => $role->description,
        ];

        $transformedResource = $this->transformer->transform($role);

        $this->assertEquals($expected, $transformedResource);
    }

    public function testAvailableIncludes(): void
    {
        $this->assertSame([
            'permissions',
        ], $this->transformer->getAvailableIncludes());
    }

    public function testDefaultIncludes(): void
    {
        $this->assertSame([], $this->transformer->getDefaultIncludes());
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->transformer = new RoleTransformer();
    }
}
