<?php

namespace App\Http\Middleware;

use Closure;

class AddUser
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
        /**
         * only super admins have the right to add users
         */

        // check if user is super admin
        if(!\Auth::user()->is_staff || !\Auth::user()->is_super) {
            // user is not super admin - return user to previous page
            return redirect()
                    ->back();
        }
        return $next($request);
    }
}
