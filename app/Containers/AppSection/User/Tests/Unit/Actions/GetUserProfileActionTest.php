<?php

namespace App\Containers\AppSection\User\Tests\Unit\Actions;

use App\Containers\AppSection\User\Actions\GetUserProfileAction;
use App\Containers\AppSection\User\Models\User;
use App\Containers\AppSection\User\Tests\UnitTestCase;
use PHPUnit\Framework\Attributes\CoversClass;

#[CoversClass(GetUserProfileAction::class)]
final class GetUserProfileActionTest extends UnitTestCase
{
    public function testCanGetUserProfile(): void
    {
        $user = User::factory()->createOne();
        auth()->setUser($user);
        $action = app(GetUserProfileAction::class);

        $foundUser = $action->run();

        $this->assertInstanceOf(User::class, $foundUser);
        $this->assertSame($user->id, $foundUser->id);
    }
}
