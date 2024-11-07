<?php

use App\Http\Middleware\CheckIfUserInactive;
use App\Http\Middleware\CheckPermission;
use App\Http\Middleware\ExpectsJson;
use App\Http\Middleware\NoCache;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->redirectGuestsTo('/login');
        $middleware->alias([
            'checkInactive' => CheckIfUserInactive::class,
            'checkPermission' => CheckPermission::class,
            'expectsJson' => ExpectsJson::class,
            'noCache' => NoCache::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
