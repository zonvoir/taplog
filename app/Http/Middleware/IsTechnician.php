<?php

namespace App\Http\Middleware;

use Closure;

class IsTechnician
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
        if(auth()->user()->type == 'technician' && auth()->user()->client_id){
            return $next($request);
        }
        return redirect("home")->with("error","You don't have access.");
    }
}
