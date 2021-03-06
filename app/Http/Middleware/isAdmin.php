<?php

namespace App\Http\Middleware;

use Auth;
use Closure;

class isAdmin
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
        if(Auth::user()->email!==getenv('USER_EMAIL')){
            return redirect('/');
        }

        return $next($request);
    }
}
