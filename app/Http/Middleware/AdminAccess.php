<?php

namespace App\Http\Middleware;

use Closure;
use App\SM\SM;
use Illuminate\Support\Facades\Auth;

class AdminAccess {
	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @param  \Closure $next
	 *
	 * @return mixed
	 */
	public function handle( $request, Closure $next ) {

		if ( SM::check_current_url_user_access( $request ) ) {
			return $next( $request );
		} else {
			if ( $request->ajax() ) {
				return response('You don\'t have enough permission to see this page! Please contact with your Admin!', 401);
			} else {
				header( 'Location: ' . url( config( 'constant.smAdminSlug' ) . '/access_denied' ) );
				exit();
			}
		}
	}
}
