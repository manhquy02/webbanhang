<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\CheckAdminPermission;
use App\Http\Middleware\PreventLogin;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
         $middleware->alias([
            'checkpermission' => CheckAdminPermission::class,
        ]);
         $middleware->append(PreventLogin::class);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
    

