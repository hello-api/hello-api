<?php

use App\Containers\AppSection\Authentication\UI\WEB\Controllers\LoginPageController;
use Illuminate\Support\Facades\Route;

Route::get('login', LoginPageController::class)
    ->name('login-page')
    ->middleware(['guest']);
