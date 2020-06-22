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
        $confidential_views_of_others = ConfidentialViewer::where('user_id', '!=', Auth::user()->user_id)
                                                ->get()
                                                ->pluck('record_id')
                                                ->toArray();

        $records = Record::whereNotIn('record_id', $confidential_views_of_others)->get();

        if(!$records->contains('record_id', $request->route('record'))
            return back();

        return $next($request);
    }
}