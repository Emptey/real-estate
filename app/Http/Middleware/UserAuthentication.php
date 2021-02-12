<?php

namespace App\Http\Middleware;

use Closure;

class UserAuthentication
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
        // check if user is logged in
        if (!\Auth::check() || $two_fa != 1 || !\Auth::user()->is_active = 1) {
            // user not authenticated - redirect user to login page
            \Auth::logout();
            return redirect()
                    ->route('get-user-login');
        }

        return $next($request);
    }
}
