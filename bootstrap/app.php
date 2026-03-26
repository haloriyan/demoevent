<?php

use App\Http\Middleware\Admin;
use App\Http\Middleware\Booth;
use App\Http\Middleware\ConstructionPreview;
use App\Http\Middleware\Cors;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->appendToGroup('Admin', [
            Admin::class,
        ]);
        $middleware->appendToGroup('Booth', [
            Booth::class,
        ]);
        $middleware->appendToGroup('Cors', [
            Cors::class,
        ]);
        $middleware->appendToGroup('Construction', [
            ConstructionPreview::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
