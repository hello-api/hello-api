<?php

namespace App\Containers\AppSection\User\Tests\Unit\Tasks;

use App\Containers\AppSection\User\Models\User;
use App\Containers\AppSection\User\Tasks\CreateUserTask;
use App\Containers\AppSection\User\Tests\UnitTestCase;
use App\Ship\Exceptions\CreateResourceFailed;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use PHPUnit\Framework\Attributes\CoversClass;

#[CoversClass(CreateUserTask::class)]
final class CreateUserTaskTest extends UnitTestCase
{
    public function testCreateUser(): void
    {
        $data = [
            'email' => 'gandalf@the.grey',
            'password' => 'youShallNotPass',
        ];

        $user = app(CreateUserTask::class)->run($data);

        $this->assertModelExists($user);
        $this->assertInstanceOf(User::class, $user);
        $this->assertSame(Str::lower($data['email']), $user->email);
        $this->assertTrue(Hash::check($data['password'], $user->password));
    }

    public function testCreateUserWithInvalidData(): void
    {
        $this->expectException(CreateResourceFailed::class);
        $this->expectExceptionMessage('User creation failed.');

        $data = [
            'email' => 'gandalf@the.grey',
            'password' => 'youShallNotPass',
            'birth' => 'wrong-format',
        ];

        app(CreateUserTask::class)->run($data);
    }
}
