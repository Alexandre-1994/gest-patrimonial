<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    protected $middleware = [
        // Middleware global
    ];

    protected $middlewareGroups = [
        'web' => [
            // Middleware para rotas web
        ],
        'api' => [
            // Middleware para rotas API
        ],
    ];

    protected $routeMiddleware = [
        // Middleware de rota
    ];

    protected $commands = [
        \App\Console\Commands\CreateUserCommand::class,
        \App\Console\Commands\ResetUserPasswordCommand::class,
    ];
}
