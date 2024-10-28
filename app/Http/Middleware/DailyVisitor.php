<?php

namespace App\Http\Middleware;

use App\SM\SM;
use Closure;

class DailyVisitor
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
	    SM::sm_daily_visit();
	    SM::setPreviousUrl();
        return $next($request);
    }
}
