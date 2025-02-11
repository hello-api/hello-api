<?php

namespace App\Containers\AppSection\User\Tests\Unit\Actions;

use App\Containers\AppSection\User\Actions\CreateAdminAction;
use App\Containers\AppSection\User\Tests\UnitTestCase;
use PHPUnit\Framework\Attributes\CoversClass;

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

        $this->assertSame($data['email'], $admin->email);
        $this->assertTrue($admin->isSuperAdmin());
        $this->assertNotNull($admin->email_verified_at);
    }

    public function testGivenInvalidDataThrowExceptionAndRollbackDB(): void
    {
        $this->expectException(\Error::class);

        $data = ['name' => new class {}];

        $admin = app(CreateAdminAction::class)->run($data);

        $this->assertModelMissing($admin);
    }
}
