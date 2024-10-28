<?php

namespace App\Http\Middleware;

use App\SM\SM;
use Closure;
use Illuminate\Support\Facades\Auth;

class AdminAuth {
	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @param  \Closure $next
	 *
	 * @return mixed
	 */
	public function handle( $request, Closure $next, $guard = 'admins' ) {
		if ( Auth::guard( $guard )->guest() ) {
			if ( $request->ajax() || $request->wantsJson() ) {
				return response( "Unauthorised", 401 );
			} else {
				return redirect()->guest( SM::smAdminSlug( "login" ) );
			}
		}

		return $next( $request );
	}
}
