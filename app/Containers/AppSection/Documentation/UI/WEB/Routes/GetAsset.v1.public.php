<?php

use Illuminate\Support\Facades\Route;

Route::get('/assets/{container}/{type}/{file}', static function ($container, $type, $file) {
    $container = ucfirst($container);

    $path = app_path("Containers/AppSection/$container/UI/WEB/Views/swagger/$file");

    if (File::exists($path)) {
        return match ($type) {
            'js' => response()->file($path, ['Content-Type' => 'application/javascript']),
            'css' => response()->file($path, ['Content-Type' => 'text/css']),
            'json' => response()->file($path, ['Content-Type' => 'application/json']),
            'png' => response()->file($path, ['Content-Type' => 'image/png']),
            'svg' => response()->file($path, ['Content-Type' => 'image/svg+xml']),
            'ico' => response()->file($path, ['Content-Type' => 'image/x-icon']),
            default => response()->file($path),
        };
    }

    return response()->json([], 404);
});
