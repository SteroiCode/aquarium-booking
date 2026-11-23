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
    ->withMiddleware(function (Middleware $middleware): void {
        // Trust Railway's load balancer proxy (fixes HTTPS detection + CSRF)
        $middleware->trustProxies(at: '*');

        $middleware->alias([
            'admin' => \App\Http\Middleware\AdminMiddleware::class,
            'admin.session' => \App\Http\Middleware\AdminSessionMiddleware::class,
            'user.session' => \App\Http\Middleware\UserSessionMiddleware::class,
        ]);

        // Exclude locale cookie from encryption so SetLocale can read it directly
        $middleware->encryptCookies(except: ['locale']);

        $middleware->append(\App\Http\Middleware\SetLocale::class);

        // Ensure session cookie middleware runs before session is started
        $middleware->priority([
            \App\Http\Middleware\AdminSessionMiddleware::class,
            \App\Http\Middleware\UserSessionMiddleware::class,
            \Illuminate\Session\Middleware\StartSession::class,
        ]);
        
        // Redirect guests to login page
        $middleware->redirectGuestsTo('/login');
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
