<?php

namespace App\Http\Middleware;

use Closure;
use App\Course;

class UserNotRegisteredOnCourse
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
        $HTTP_CODE_USER_NOT_REGISTERED = 404;

        $result = Course::whereHas('users', function ($query) use($request) {
            $query->where('user_id', auth()->user()->id);
            $query->where('course_id', $request->route('courseId'));
        })->first();

        if($result != null)
        {
            return $next($request);
        }

        return response()->json([
            'message' => 'User not found'
        ], 404);
    }
}
