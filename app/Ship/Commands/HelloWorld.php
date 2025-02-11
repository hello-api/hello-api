<?php

namespace App\Ship\Commands;

use App\Ship\Parents\Commands\Command;

final class HelloWorld extends Command
{
    protected $signature = 'hello:world';
    protected $description = 'Says Hello World!';

    public function handle(): void
    {
        $this->line('Hello World!');
    }
}
