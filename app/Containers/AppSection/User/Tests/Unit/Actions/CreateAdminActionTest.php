<?php

namespace App\Containers\AppSection\User\Tests\Unit\Actions;

use App\Containers\AppSection\User\Actions\CreateAdminAction;
use App\Containers\AppSection\User\Tests\UnitTestCase;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Group;

#[Group('user')]
#[CoversClass(CreateAdminAction::class)]
final class CreateAdminActionTest extends UnitTestCase
{
    public function testCreateAdmin(): void
    {
        $data = [
            'email' => 'ganldalf@the.grey',
            'password' => 'youShallNotPass',
            'name' => 'Super Admin',
        ];

        $admin = app(CreateAdminAction::class)->run($data);

        $this->assertSame($data['email'], $admin->email->value);
        foreach (array_keys(config('auth.guards')) as $guardName) {
            $this->assertTrue($admin->hasRole(config('appSection-authorization.admin_role'), $guardName));
        }
        $this->assertNotNull($admin->email_verified_at);
    }

    public function testGivenInvalidDataThrowExceptionAndRollbackDB(): void
    {
        $this->expectException(\Exception::class);

        config()->set('appSection-authorization.admin_role', 'not_existing_role');
        $data = [
            'email' => 'ganldalf@the.grey',
            'password' => 'youShallNotPass',
            'name' => 'Super Admin',
        ];

        $admin = app(CreateAdminAction::class)->run($data);

        $this->assertModelMissing($admin);
    }
}
