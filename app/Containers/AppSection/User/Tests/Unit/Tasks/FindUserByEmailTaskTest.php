<?php

namespace App\Containers\AppSection\User\Tests\Unit\Tasks;

use App\Containers\AppSection\User\Data\Factories\UserFactory;
use App\Containers\AppSection\User\Tasks\FindUserByEmailTask;
use App\Containers\AppSection\User\Tests\UnitTestCase;
use App\Ship\Exceptions\NotFoundException;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Group;

#[Group('user')]
#[CoversClass(FindUserByEmailTask::class)]
final class FindUserByEmailTaskTest extends UnitTestCase
{
    public function testFindUserByEmail(): void
    {
        $user = UserFactory::new()->createOne();

        $foundUser = app(FindUserByEmailTask::class)->run($user->email);

        $this->assertTrue($user->email->equals($foundUser->email));
    }

    public function testFindUserWithInvalidEmail(): void
    {
        $this->expectException(NotFoundException::class);

        $noneExistingEmail = 'gandalf@the.grey';

        app(FindUserByEmailTask::class)->run($noneExistingEmail);
    }
}
