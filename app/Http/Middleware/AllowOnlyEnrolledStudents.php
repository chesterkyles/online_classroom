<?php

namespace App\Http\Middleware;

use App\Subject;
use Closure;

class AllowOnlyEnrolledStudents
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
        if(auth()->user()->account_type == 'teacher'){
            if($request->subject->teacher_id == auth()->user()->id)
                return $next($request);
        } else {
            if($request->subject->students->where('user_id', auth()->user()->id)->first()->pivot->accepted)
                return $next($request);
        }

        return abort(403);
    }

}
