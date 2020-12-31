<?php

namespace App\Http\Middleware;

use Closure;

class AdminAuthentication
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
        if (!\Auth::check()) {
            // loggout user
            \Auth::logout();
            return redirect()->route('admin-login');
        }
        return $next($request);
    }
}
