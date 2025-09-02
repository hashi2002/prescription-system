<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsureUserType
{
    public function handle(Request $request, Closure $next, $type)
    {
        if (!auth()->check() || auth()->user()->user_type !== $type) {
            abort(403, 'Unauthorized access.');
        }

        return $next($request);
    }
}