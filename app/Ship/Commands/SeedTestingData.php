<?php

namespace App\Ship\Commands;

use Apiato\Abstract\Commands\Command as ParentCommand;
use App\Ship\Seeders\TestingDataSeeder;

final class SeedTestingData extends ParentCommand
{
    protected $signature = 'apiato:seed-test';
    protected $description = 'Seed testing data.';

    public function handle(): void
    {
        $this->call('db:seed', [
            '--class' => TestingDataSeeder::class,
        ]);

        $this->info('Testing Data Seeded Successfully.');
    }
}
