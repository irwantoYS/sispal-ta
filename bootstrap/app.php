<?php

use App\Http\Middleware\DriverMiddleware;
use App\Http\Middleware\HSSEMiddleware;
use App\Http\Middleware\ManagerAreaMiddleware;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'ManagerAreaMiddleware' => ManagerAreaMiddleware::class,
            'HSSEMiddleware' => HSSEMiddleware::class,
            'DriverMiddleware' => DriverMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
