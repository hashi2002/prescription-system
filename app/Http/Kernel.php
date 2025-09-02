<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    /**
     * The application's global HTTP middleware stack.
     */
    protected $middleware = [
        // ... global middleware
    ];

    /**
     * The application's route middleware groups.
     */
    protected $middlewareGroups = [
        'web' => [
            // ... web middleware
        ],

        'api' => [
            // ... api middleware
        ],
    ];

    /**
     * The application's middleware aliases.
     */
    protected $middlewareAliases = [
        'auth' => \App\Http\Middleware\Authenticate::class,
        'user.type' => \App\Http\Middleware\EnsureUserType::class,
        'user' => \App\Http\Middleware\UserMiddleware::class,
        // ... other middleware
    ];
}