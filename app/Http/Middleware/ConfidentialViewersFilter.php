<?php

namespace App\Http\Middleware;

use Closure;
use App\Record;
use App\ConfidentialViewer;
use Illuminate\Support\Facades\Auth;

class ConfidentialViewersFilter
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
        if($request->route('record'))
        {
            if($request->route('record')->service->is_confidential)
            {
                if($request->route('record')->confidential_viewers->pluck('user_id')->contains(Auth::user()->user_id))
                    return $next($request);
                else
                    return back();
            }

            else
                return $next($request);
        }

        else
            return back();
    }
}