<?php

namespace App\Http\Middleware;

use Closure;

class IsVendor
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
        /*return $next($request);*/
        if(auth()->user()->type == 'vendor' || auth()->user()->type == 'subadmin'){
            return $next($request);
        }
   
        return redirect("home")->with("error","You don't have Super Admin access.");
    }
}
