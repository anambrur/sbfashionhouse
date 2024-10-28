<?php

namespace App\Http\Middleware;

use Closure;

class CheckoutAccess {
	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @param  \Closure $next
	 *
	 * @return mixed
	 */
	public function handle( $request, Closure $next ) {
		if ( \Auth::check() || \Session::has( "guest" ) ) {
			return $next( $request );
		} else {
			return redirect("/login")->with( "w_message", "Please login to checkout" );
		}
	}
}
