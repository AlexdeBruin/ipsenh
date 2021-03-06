<?php

namespace App\Http\Middleware;

use Closure;

class HasRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $role)
    {
        if (auth()->check()) {
            if (auth()->check() && !auth()->user()->hasRole($role)) {
                abort(401, 'unauthorized');
            }
        }
        return $next($request);
    }
}
