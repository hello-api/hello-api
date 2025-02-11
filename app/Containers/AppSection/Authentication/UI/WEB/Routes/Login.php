<?php

use App\Containers\AppSection\Authentication\UI\WEB\Controllers\LoginController;
use Illuminate\Support\Facades\Route;

Route::post('login', LoginController::class)
    ->name('login');
