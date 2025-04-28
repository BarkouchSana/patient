<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    
    
    protected $middleware = [
        // Middleware global
        \App\Http\Middleware\CorsMiddleware::class,
        
        \Illuminate\Foundation\Http\Middleware\CheckForMaintenanceMode::class,
        \Illuminate\Foundation\Http\Middleware\ValidatePostSize::class,
        \Illuminate\Foundation\Http\Middleware\TrimStrings::class,
        \Illuminate\Routing\Middleware\SubstituteBindings::class,
        \Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull::class,
    ];

    protected $middlewareGroups = [
        'web' => [
            // We're API‑only, so no need for web middleware here:
            // \App\Http\Middleware\EncryptCookies::class,
            // \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            // \Illuminate\Session\Middleware\StartSession::class,
            // \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            // \App\Http\Middleware\VerifyCsrfToken::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ],

        'api' => [
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ],
    ];

    protected $routeMiddleware = [
        // 'auth' => \App\Http\Middleware\Authenticate::class,
        // 'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
        // 'cache.headers' => \Illuminate\Http\Middleware\SetCacheHeaders::class,
        // 'can' => \Illuminate\Auth\Middleware\Authorize::class,
        // 'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,
        // 'password.confirm' => \Illuminate\Auth\Middleware\RequirePassword::class,
        // 'signed' => \Illuminate\Routing\Middleware\ValidateSignature::class,
        // 'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class,
        // 'verified' => \Illuminate\Auth\Middleware\EnsureEmailIsVerified::class,
       
        // 'jwt.auth'    => \Tymon\JWTAuth\Http\Middleware\Authenticate::class,
        // 'jwt.refresh' => \Tymon\JWTAuth\Http\Middleware\RefreshToken::class,
    ];
}