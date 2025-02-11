<?php

namespace App\Containers\AppSection\User\Tests\Unit\Tasks;

use App\Containers\AppSection\User\Data\Repositories\UserRepository;
use App\Containers\AppSection\User\Models\User;
use App\Containers\AppSection\User\Tasks\FindUserByIdTask;
use App\Containers\AppSection\User\Tests\UnitTestCase;
use PHPUnit\Framework\Attributes\CoversClass;

#[CoversClass(FindUserByIdTask::class)]
final class FindUserByIdTaskTest extends UnitTestCase
{
    public function testFindUserById(): void
    {
        $user = User::factory()->createOne();
        $repositoryMock = $this->partialMock(UserRepository::class);
        $repositoryMock->expects('getById')->once()->with($user->id)->andReturn($user);

        app(FindUserByIdTask::class)->run($user->id);
    }
}
