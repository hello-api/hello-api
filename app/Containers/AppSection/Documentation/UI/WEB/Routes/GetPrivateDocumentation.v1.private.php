<?php

use App\Containers\AppSection\Documentation\UI\WEB\Controllers\Controller;
use Illuminate\Support\Facades\Route;

if (config('documentation.types.private.url')) {
    if (config('documentation.protect-private-docs')) {
        Route::get(config('documentation.types.private.url'), [Controller::class, 'showPrivateDocs'])
            ->name('private_docs')
            ->middleware('auth:web');
    } else {
        Route::get(config('documentation.types.private.url'), [Controller::class, 'showPrivateDocs'])
            ->name('private_docs');
    }
}
