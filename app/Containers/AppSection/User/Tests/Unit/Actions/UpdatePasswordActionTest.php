<?php

namespace App\Containers\AppSection\User\Tests\Unit\Actions;

use App\Containers\AppSection\User\Actions\UpdatePasswordAction;
use App\Containers\AppSection\User\Models\User;
use App\Containers\AppSection\User\Notifications\PasswordUpdatedNotification;
use App\Containers\AppSection\User\Tests\UnitTestCase;
use App\Containers\AppSection\User\UI\API\Requests\UpdatePasswordRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use PHPUnit\Framework\Attributes\CoversClass;

#[CoversClass(UpdatePasswordAction::class)]
final class UpdatePasswordActionTest extends UnitTestCase
{
    public function testCanUpdateCurrentPassword(): void
    {
        Notification::fake();
        $user = User::factory()->createOne(['password' => 'youShallNotPass']);
        $data = [
            'user_id' => $user->getHashedKey(),
            'password' => 'youShallNotPass',
            'new_password' => 'test',
        ];
        $request = UpdatePasswordRequest::injectData($data)->withUrlParameters(['user_id' => $user->id]);
        $action = app(UpdatePasswordAction::class);

        $result = $action->run($request->user_id, $request->new_password);

        $this->assertTrue(Hash::check($data['new_password'], $result->password));
        Notification::assertSentTo($user, PasswordUpdatedNotification::class);
    }
}
