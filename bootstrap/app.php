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

        // ESCUDO PROXY: Le decimos a Laravel que confíe en el servidor de Render (Evita el Error 419 en general)
        $middleware->trustProxies(at: '*');

        // BYPASS CSRF: Permitir cerrar sesión aunque el token de la página haya expirado (Solución final al 419 del Logout)
        $middleware->validateCsrfTokens(except: [
            'logout',
            '/logout'
        ]);

        // AQUÍ LE ENSEÑAMOS A LARAVEL LAS PALABRAS DE SPATIE (Tus roles)
        $middleware->alias([
            'role' => \Spatie\Permission\Middleware\RoleMiddleware::class,
            'permission' => \Spatie\Permission\Middleware\PermissionMiddleware::class,
            'role_or_permission' => \Spatie\Permission\Middleware\RoleOrPermissionMiddleware::class,
        ]);

    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
