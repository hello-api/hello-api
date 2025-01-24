<?php

namespace App\Containers\AppSection\User\Tests\Unit\Tasks;

use App\Containers\AppSection\User\Models\User;
use App\Containers\AppSection\User\Tasks\FindUserByEmailTask;
use App\Containers\AppSection\User\Tests\UnitTestCase;
use App\Ship\Exceptions\ResourceNotFound;
use PHPUnit\Framework\Attributes\CoversClass;

#[CoversClass(FindUserByEmailTask::class)]
final class FindUserByEmailTaskTest extends UnitTestCase
{
    public function testFindUserByEmail(): void
    {
        $user = User::factory()->createOne();

        $foundUser = app(FindUserByEmailTask::class)->run($user->email);

        $this->assertSame($user->email, $foundUser->email);
    }

    public function testFindUserWithInvalidEmail(): void
    {
        $this->expectException(ResourceNotFound::class);

        $noneExistingEmail = 'gandalf@the.grey';

        app(FindUserByEmailTask::class)->run($noneExistingEmail);
    }
}
