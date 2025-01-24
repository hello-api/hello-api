<?php

use Apiato\Foundation\Apiato;
use Apiato\Support\Middleware\ProcessETag;
use Apiato\Support\Middleware\Profiler;
use Apiato\Support\Middleware\ValidateJsonContent;
use App\Containers\AppSection\Authentication\UI\WEB\Controllers\HomePageController;
use App\Containers\AppSection\Authentication\UI\WEB\Controllers\LoginPageController;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;

$basePath = dirname(__DIR__);
$apiato = Apiato::configure(basePath: $basePath)->create();

return Application::configure(basePath: $basePath)
    ->withProviders($apiato->providers())
    ->withEvents($apiato->events())
    ->withRouting(
        web: $apiato->webRoutes(),
        channels: __DIR__ . '/../app/Ship/Broadcasting/channels.php',
        health: '/up',
        then: static fn () => $apiato->registerApiRoutes(),
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->api(append: [
            ValidateJsonContent::class,
            ProcessETag::class,
            Profiler::class,
        ]);
        $middleware->redirectUsersTo(function (Request $request) {
            return redirect()->action(HomePageController::class);
        });
        $middleware->redirectGuestsTo(function (Request $request) {
            return redirect()->action(LoginPageController::class);
        });
    })
    ->withCommands($apiato->commands())
    // TODO: Create a Laravel PR
    //  It seems there is no defined default behaviour for the `withExceptions` method.
    //  So, if withExceptions is removed, we get a binding resolution error.
    ->withExceptions(static function (Exceptions $exceptions) {})
    ->create();
