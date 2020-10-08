<?php

namespace App\Http\Middleware;

use Closure;

class IsClient
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
        // return $next($request);
        if(auth()->user()->type == 'client'){
            return $next($request);
        }
        return redirect("home")->with("error","You don't have access.");
    }
}
