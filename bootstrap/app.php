<?php

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
        // Pendaftaran Alias Middleware
        $middleware->alias([
            // Alias standar untuk otentikasi (biasanya didefinisikan oleh starter kit)
            'auth' => \Illuminate\Auth\Middleware\Authenticate::class, 
            
            // Alias kustom untuk role Admin yang kita buat
            'admin' => \App\Http\Middleware\AdminMiddleware::class,
        ]);
        
        
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();