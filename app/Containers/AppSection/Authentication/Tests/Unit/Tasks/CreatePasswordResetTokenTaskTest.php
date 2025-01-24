<?php

namespace App\Containers\AppSection\Authentication\Tests\Unit\Tasks;

use App\Containers\AppSection\Authentication\Tasks\CreatePasswordResetTokenTask;
use App\Containers\AppSection\Authentication\Tests\UnitTestCase;
use App\Containers\AppSection\User\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use PHPUnit\Framework\Attributes\CoversClass;

#[CoversClass(CreatePasswordResetTokenTask::class)]
final class CreatePasswordResetTokenTaskTest extends UnitTestCase
{
    public function testCreatePasswordResetTask(): void
    {
        $user = User::factory()->createOne();
        $task = app(CreatePasswordResetTokenTask::class);

        $token = $task->run($user);

        $this->assertIsString($token);
        $this->assertTrue(Hash::check($token, DB::table('password_reset_tokens')->where('email', $user->email)->first()->token));
    }
}
