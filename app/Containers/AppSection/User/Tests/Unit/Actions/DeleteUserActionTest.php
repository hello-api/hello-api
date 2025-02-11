<?php

namespace App\Containers\AppSection\User\Tests\Unit\Actions;

use App\Containers\AppSection\User\Actions\DeleteUserAction;
use App\Containers\AppSection\User\Exceptions\FailedToDeleteUser;
use App\Containers\AppSection\User\Models\User;
use App\Containers\AppSection\User\Tests\UnitTestCase;
use App\Containers\AppSection\User\UI\API\Requests\DeleteUserRequest;
use PHPUnit\Framework\Attributes\CoversClass;

#[CoversClass(DeleteUserAction::class)]
final class DeleteUserActionTest extends UnitTestCase
{
    public function testCanDeleteAnotherUser(): void
    {
        $authenticatedUser = User::factory()->createOne();
        $anotherUser = User::factory()->createOne();
        $request = DeleteUserRequest::injectData([], $authenticatedUser)
            ->withUrlParameters(['user_id' => $anotherUser->id]);
        $action = app(DeleteUserAction::class);

        $result = $action->run($request);

        $this->assertTrue($result);
        $this->assertModelMissing($anotherUser);
    }

    public function testCannotDeleteItself(): void
    {
        $this->expectException(FailedToDeleteUser::class);

        $user = User::factory()->createOne();
        $request = DeleteUserRequest::injectData([], $user)
            ->withUrlParameters(['user_id' => $user->id]);
        $action = app(DeleteUserAction::class);

        $action->run($request);
    }
}
