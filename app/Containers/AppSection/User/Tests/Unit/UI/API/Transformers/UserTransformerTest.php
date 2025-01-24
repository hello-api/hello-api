<?php

namespace App\Containers\AppSection\User\Tests\Unit\UI\API\Transformers;

use App\Containers\AppSection\Authorization\Models\Permission;
use App\Containers\AppSection\Authorization\Models\Role;
use App\Containers\AppSection\User\Models\User;
use App\Containers\AppSection\User\Tests\UnitTestCase;
use App\Containers\AppSection\User\UI\API\Transformers\UserTransformer;
use PHPUnit\Framework\Attributes\CoversClass;

#[CoversClass(UserTransformer::class)]
final class UserTransformerTest extends UnitTestCase
{
    private UserTransformer $transformer;

    public function testCanTransformSingleObject(): void
    {
        $user = User::factory()->createOne();
        $expected = [
            'object' => $user->getResourceKey(),
            'id' => $user->getHashedKey(),
            'name' => $user->name,
            'email' => $user->email,
            'email_verified_at' => $user->email_verified_at,
            'gender' => $user->gender,
            'birth' => $user->birth,
        ];

        $transformedResource = $this->transformer->transform($user);

        $this->assertEquals($expected, $transformedResource);
    }

    public function testAvailableIncludes(): void
    {
        $this->assertSame([
            'roles',
            'permissions',
        ], $this->transformer->getAvailableIncludes());
    }

    public function testDefaultIncludes(): void
    {
        $this->assertSame([], $this->transformer->getDefaultIncludes());
    }

    public function testIncludeRoles(): void
    {
        $user = User::factory()->createOne();
        $roles = Role::factory()->count(3)->create();
        $user->roles()->attach($roles);

        $resource = $this->transformer->includeRoles($user);

        $this->assertSame($user->roles, $resource->getData());
    }

    public function testIncludePermissions(): void
    {
        $user = User::factory()->createOne();
        $permissions = Permission::factory()->count(3)->create();
        $user->permissions()->attach($permissions);

        $resource = $this->transformer->includePermissions($user);

        $this->assertSame($user->permissions, $resource->getData());
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->transformer = new UserTransformer();
    }
}
