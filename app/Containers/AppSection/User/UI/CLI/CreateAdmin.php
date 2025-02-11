<?php

namespace App\Containers\AppSection\User\UI\CLI;

use App\Containers\AppSection\User\Actions\CreateAdminAction;
use App\Ship\Parents\Commands\Command as ParentCommand;

final class CreateAdmin extends ParentCommand
{
    protected $signature = 'create:admin';
    protected $description = 'Create a new User with the ADMIN role';

    public function handle(CreateAdminAction $action): void
    {
        $username = $this->ask('Enter the username for this user');
        $email = $this->ask('Enter the email address of this user');
        $password = $this->secret('Enter the password for this user');
        $password_confirmation = $this->secret('Please confirm the password');

        if ($password !== $password_confirmation) {
            $this->error('Passwords does not match - exiting!');

            return;
        }

        $data = [
            'name' => $username,
            'email' => $email,
            'password' => $password,
        ];

        try {
            $action->run($data);
        } catch (\Exception $exception) {
            $this->error($exception->getMessage());

            return;
        }

        $this->info('Admin ' . $email . ' successfully created');
    }
}
