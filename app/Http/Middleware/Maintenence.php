<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use App\SM\SM;

class Maintenence {
	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @param  \Closure $next
	 *
	 * @return mixed
	 */
	public function handle( $request, Closure $next ) {
		$is_maintenance_enable = SM::get_setting_value( 'is_maintenance_enable' );
		SM::templateSalt();
		if ( Auth::guard( 'admins' )->guest() && $is_maintenance_enable==1) {
			return redirect( 'maintenance' );
		}
		return $next( $request );
	}
}
