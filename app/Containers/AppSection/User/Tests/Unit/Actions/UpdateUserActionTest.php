<?php

namespace App\Containers\AppSection\User\Tests\Unit\Actions;

use App\Containers\AppSection\User\Actions\UpdateUserAction;
use App\Containers\AppSection\User\Enums\Gender;
use App\Containers\AppSection\User\Models\User;
use App\Containers\AppSection\User\Tests\UnitTestCase;
use App\Containers\AppSection\User\UI\API\Requests\UpdateUserRequest;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use PHPUnit\Framework\Attributes\CoversClass;

#[CoversClass(UpdateUserAction::class)]
final class UpdateUserActionTest extends UnitTestCase
{
    public function testCanUpdateUser(): void
    {
        $user = User::factory()
            ->gender(Gender::FEMALE)
            ->createOne(['password' => 'youShallNotPass']);
        $data = [
            'name' => 'a name',
            'gender' => Gender::MALE->value,
            'birth' => Carbon::today()->toIso8601String(),
            'password' => 'youShallNotPass',
            'new_password' => 'test',
        ];
        $request = UpdateUserRequest::injectData($data, $user)->withUrlParameters(['user_id' => $user->id]);
        $action = app(UpdateUserAction::class);

        $result = $action->run($request);

        $this->assertSame($data['name'], $result->name);
        $this->assertSame(Gender::from($data['gender']), $result->gender);
        $this->assertTrue($result->birth->isSameDay($data['birth']));
        $this->assertTrue(Hash::check($data['new_password'], $result->password));
    }
}
