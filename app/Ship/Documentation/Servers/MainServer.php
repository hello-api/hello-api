<?php

namespace App\Ship\Documentation\Servers;

use GoldSpecDigital\ObjectOrientedOAS\Objects\Server;
use MohammadAlavi\LaravelOpenApi\Factories\ServerFactory;

class MainServer extends ServerFactory
{
    public function build(): Server
    {
        return Server::create()
            ->url(config('app.url'))
            ->description('Main server');
    }
}
