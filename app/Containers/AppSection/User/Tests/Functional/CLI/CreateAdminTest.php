<?php

namespace App\Containers\AppSection\User\Tests\Functional\CLI;

use App\Containers\AppSection\User\Actions\CreateAdminAction;
use App\Containers\AppSection\User\Models\User;
use App\Containers\AppSection\User\Tests\Functional\CliTestCase;
use App\Containers\AppSection\User\UI\CLI\CreateAdmin;
use Illuminate\Support\Facades\Hash;
use PHPUnit\Framework\Attributes\CoversClass;

#[CoversClass(CreateAdmin::class)]
final class CreateAdminTest extends CliTestCase
{
    public function testCanCreateAdmin(): void
    {
        $data = [
            'name' => 'admin',
            'email' => 'new@admin.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ];
        $this->artisan('create:admin')
            ->expectsQuestion('Enter the username for this user', $data['name'])
            ->expectsQuestion('Enter the email address of this user', $data['email'])
            ->expectsQuestion('Enter the password for this user', $data['password'])
            ->expectsQuestion('Please confirm the password', $data['password_confirmation'])
            // ->expectsOutput('Admin ' . $data['email'] . ' successfully created')
            ->assertSuccessful();

        $this->assertDatabaseHas('users', [
            'name' => $data['name'],
            'email' => $data['email'],
        ]);
        $this->assertTrue(Hash::check($data['password'], User::where('email', $data['email'])->first()->password));
    }

    public function testErrorsOnNotMatchingPassword(): void
    {
        $data = [
            'name' => 'admin',
            'email' => 'new@admin.com',
            'password' => 'password',
            'password_confirmation' => 'not_matching_password',
        ];

        $this->artisan('create:admin')
            ->expectsQuestion('Enter the username for this user', $data['name'])
            ->expectsQuestion('Enter the email address of this user', $data['email'])
            ->expectsQuestion('Enter the password for this user', $data['password'])
            ->expectsQuestion('Please confirm the password', $data['password_confirmation'])
            ->expectsOutput('Passwords does not match - exiting!')
            ->assertSuccessful();

        $this->assertDatabaseMissing('users', [
            'name' => $data['name'],
            'email' => $data['email'],
        ]);
    }

    public function testOutputsExceptionMessages(): void
    {
        $data = [
            'name' => 'admin',
            'email' => 'new@admin.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ];
        $this->partialMock(CreateAdminAction::class)
            ->expects('run')->andThrowExceptions([
                new \Exception('This is an exception message'),
            ]);

        $this->artisan('create:admin')
            ->expectsQuestion('Enter the username for this user', $data['name'])
            ->expectsQuestion('Enter the email address of this user', $data['email'])
            ->expectsQuestion('Enter the password for this user', $data['password'])
            ->expectsQuestion('Please confirm the password', $data['password_confirmation'])
            ->expectsOutput('This is an exception message');
    }
}
