<?php

namespace App\Http\Middleware;

use Closure;

class IsMis
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
        if(auth()->user()->type == 'mis' && auth()->user()->client_id != null){
            return $next($request);
        }
        return redirect("home")->with("error","You don't have access.");
    }
}
