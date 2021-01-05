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
        $two_fa = $request->session()->get('two_fa');
        if (!\Auth::check() || $two_fa != 1) {
            // loggout user
            \Auth::logout();
            return redirect()->route('admin-login');
        }
        return $next($request);
    }
}
