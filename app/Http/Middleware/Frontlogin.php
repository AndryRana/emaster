<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Session;

class Frontlogin
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

        // echo Session::get('frontSession');die;
        if(empty(Session::has('frontSession'))){
            return redirect('/login-register');
        }
        return $next($request);
    }
}
