<?php

use App\Http\Middleware\AdminMiddleware;
use Illuminate\Foundation\Application;
use App\Http\Middleware\AuthMiddleware;
use App\Http\Middleware\UserMiddleware;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        //Reader and Author middleware

        $middleware->alias([
            // 'authmiddleware' => AuthMiddleware::class,
            'admin' => AdminMiddleware::class,
            'user' => UserMiddleware::class

        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
