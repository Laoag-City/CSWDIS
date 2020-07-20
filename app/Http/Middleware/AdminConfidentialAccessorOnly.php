<?php

namespace App\Http\Middleware;

use Closure;

class AdminConfidentialAccessorOnly
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
        if($request->user()->is_admin || $request->user()->is_confidential_accessor)
            return $next($request);

        else
            return back();
    }
}
