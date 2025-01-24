<?php

namespace App\Containers\AppSection\User\Tests\Unit\Actions;

use App\Containers\AppSection\User\Actions\FindUserByIdAction;
use App\Containers\AppSection\User\Models\User;
use App\Containers\AppSection\User\Tests\UnitTestCase;
use App\Containers\AppSection\User\UI\API\Requests\FindUserByIdRequest;
use PHPUnit\Framework\Attributes\CoversClass;

#[CoversClass(FindUserByIdAction::class)]
final class FindUserByIdActionTest extends UnitTestCase
{
    public function testCanDeleteUser(): void
    {
        $user = User::factory()->createOne();
        $request = FindUserByIdRequest::injectData()->withUrlParameters(['user_id' => $user->id]);
        $action = app(FindUserByIdAction::class);

        $result = $action->run($request);

        $this->assertSame($user->id, $result->id);
    }
}
