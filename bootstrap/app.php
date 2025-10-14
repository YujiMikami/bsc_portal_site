<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\RoleCheck;
use App\Http\Middleware\NoCache;


return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->appendToGroup(
            'admin', [
                RoleCheck::class,
            ],
        );
        $middleware->appendToGroup(
            'web', [
                NoCache::class,
            ]
        );
        $middleware->alias([
        ]);    
    })
    
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })
    ->create();
