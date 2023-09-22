<?php

use App\Containers\AppSection\Documentation\UI\WEB\Controllers\Controller;
use Illuminate\Support\Facades\Route;

if (config('documentation.types.public.url')) {
    Route::get(config('documentation.types.public.url'), [Controller::class, 'showPublicDocs'])
        ->name('public_docs');
}
