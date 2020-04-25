<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

class AllowRouteAccessIfUser
{

    protected function getRequestType($request)
    {
        if($request->is('teacher/*')) {
            return $request->teacher;
        } else if ($request->is('student/*')) {
            return $request->student;
        }
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($this->getRequestType($request)->account_number == auth()->user()->account_number) {
            return $next($request);
        }
        return abort(403);
    }
}
