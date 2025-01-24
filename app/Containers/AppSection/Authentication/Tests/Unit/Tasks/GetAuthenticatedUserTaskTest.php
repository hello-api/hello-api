<?php

namespace App\Containers\AppSection\Authentication\Tests\Unit\Tasks;

use App\Containers\AppSection\Authentication\Tasks\GetAuthenticatedUserTask;
use App\Containers\AppSection\Authentication\Tests\UnitTestCase;
use App\Containers\AppSection\User\Models\User;
use PHPUnit\Framework\Attributes\CoversClass;

#[CoversClass(GetAuthenticatedUserTask::class)]
final class GetAuthenticatedUserTaskTest extends UnitTestCase
{
    public function testCanGetAuthenticatedUser(): void
    {
        $user = User::factory()->createOne();
        auth()->setUser($user);
        $task = app(GetAuthenticatedUserTask::class);

        $foundUser = $task->run();

        $this->assertInstanceOf(User::class, $foundUser);
        $this->assertSame($user->id, $foundUser->id);
    }

    public function testGivenUserNotAuthenticatedThrowsException(): void
    {
        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage('You are not authenticated.');

        $task = app(GetAuthenticatedUserTask::class);

        $task->run();
    }
}
