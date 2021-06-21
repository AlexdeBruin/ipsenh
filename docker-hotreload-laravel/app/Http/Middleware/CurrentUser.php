<?php

namespace App\Http\Middleware;

use Closure;

class CurrentUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if($request->route('id') != auth()->user()->id){
            return response()->json([
                'message' => 'Unauthenticated.'
            ], 401);
        }
        return $next($request);
    }
}
