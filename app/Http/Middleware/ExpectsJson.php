<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ExpectsJson
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next): mixed
    {
        if (!$request->expectsJson() && !$request->isJson()) {
            abort(404);
        }

        return $next($request);
    }
}
