<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserType
{
    public function handle(Request $request, Closure $next, string $type): Response
    {
        if (!auth()->check() || auth()->user()->user_type !== $type) {
            abort(403, 'Access denied. Required user type: ' . $type);
        }
        
        return $next($request);
    }
}