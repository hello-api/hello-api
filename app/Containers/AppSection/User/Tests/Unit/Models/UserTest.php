<?php

namespace App\Containers\AppSection\User\Tests\Unit\Models;

use App\Containers\AppSection\Authentication\Notifications\VerifyEmail;
use App\Containers\AppSection\User\Enums\Gender;
use App\Containers\AppSection\User\Models\User;
use App\Containers\AppSection\User\Tests\UnitTestCase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use PHPUnit\Framework\Attributes\CoversClass;

#[CoversClass(User::class)]
final class UserTest extends UnitTestCase
{
    public function testUsesCorrectTable(): void
    {
        $user = User::factory()->createOne();
        $table = 'users';

        $this->assertSame($table, $user->getTable());
    }

    public function testHasCorrectFillableFields(): void
    {
        $user = User::factory()->createOne();
        $fillables = [
            'name',
            'email',
            'password',
            'gender',
            'birth',
        ];

        $this->assertSame($fillables, $user->getFillable());
    }

    public function testHasCorrectCasts(): void
    {
        $user = User::factory()->createOne();
        $casts = [
            'id' => 'int',
            'email_verified_at' => 'immutable_datetime',
            'password' => 'hashed',
            'gender' => Gender::class,
            'birth' => 'immutable_date',
        ];

        $this->assertSame($casts, $user->getCasts());
    }

    public function testHasCorrectHiddenFields(): void
    {
        $user = User::factory()->createOne();
        $hiddens = [
            'password',
            'remember_token',
        ];

        $this->assertSame($hiddens, $user->getHidden());
    }

    public function testHasCorrectResourceKey(): void
    {
        $user = User::factory()->createOne();

        $this->assertSame('User', $user->getResourceKey());
    }

    public function testSendEmailVerificationNotificationWithVerificationUrl(): void
    {
        Notification::fake();
        $user = User::factory()->createOne();

        $user->sendEmailVerificationNotificationWithVerificationUrl('http://localhost');

        Notification::assertSentTo($user, VerifyEmail::class);
    }

    public function testGetHashedEmailForVerification(): void
    {
        $user = User::factory()->createOne();

        $hashedEmail = $user->getHashedEmailForVerification();

        $this->assertSame(sha1((string) $user->getEmailForVerification()), $hashedEmail);
    }

    public function testUsesEmailFieldAsDefaultLoginFieldFallback(): void
    {
        config()->unset('appSection-authentication.login.fields');
        $user = User::factory()->createOne();

        $result = (new User())->findForPassport($user->email);

        $this->assertTrue($user->is($result));
    }

    public function testCanAuthenticateUsingAllowedLoginFields(): void
    {
        config()->set('appSection-authentication.login.fields', ['name' => []]);
        $user = User::factory()->createOne();

        $result = (new User())->findForPassport($user->name);

        $this->assertTrue($user->is($result));
    }

    public function testLowerCasesEmailOnAccess(): void
    {
        $original = 'GanDalf@thE.Gray';
        $expectedGet = 'gandalf@the.gray';
        $expectedSet = 'GanDalf@thE.Gray';
        $user = User::factory()->createOne(['email' => $original]);

        $this->assertSame($expectedGet, $user->email);
        $this->assertSame($expectedSet, DB::query()->from('users')->find($user->id)->email);
    }
}
